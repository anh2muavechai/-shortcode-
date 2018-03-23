<?php
/*
Plugin Name: WP_List_Table Class Example
Plugin URI:
Description: Demo on how WP_List_Table Class works
Version: 1.0
Author: Ken Kaneki
Author URI:
*/
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Customers_List extends WP_List_Table {
	const PLUGIN_SLUG = "wp_list_table_class";

	/** Class constructor */
	public function __construct() {
		parent::__construct( [
			'singular' => __( 'Customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Customers', 'sp' ), //plural name of the listed records
			'ajax'     => true //does this table support ajax?
		] );
	}

	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function delete_customer( $id ) {
		global $wpdb;
		$wpdb->delete(
			"{$wpdb->prefix}customers",
			[ 'ID' => $id ],
			[ '%d' ]
		);
	}

	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;
		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}customers";
		return $wpdb->get_var( $sql );
	}

	/** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'No customers avaliable.', 'sp' );
	}

	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'address':
			case 'city':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
		);
	}
	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_name( $item ) {
		$delete_nonce = wp_create_nonce( 'sp_delete_customer' );
		$title        = '<strong>' . $item['name'] . '</strong>';
		$url          = '<a href="?page=' . esc_attr( $_REQUEST["page"] );
		if( isset($_REQUEST['s']) ){
			$url.= '&s=' . esc_attr( $_REQUEST['s'] );
		}
		$url.= '&action=delete';
		if( isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] = 'Filter' ){
			if( isset($_REQUEST['cat-filter']) && $_REQUEST['cat-filter'] != '' ){
				$url .= '&filter_action=Filter&cat-filter='.$_REQUEST['cat-filter'];
			}
		}
		if( isset($_REQUEST['paged']) ){
			$url.= '&paged=' . $_REQUEST['paged'];
		}
		$url.= '&customer=' . absint( $item['ID'] ) . '&_wpnonce=' . $delete_nonce;
		$url.= '">Delete</a>';
		$actions = ['delete' => $url];
		return $title . $this->row_actions( $actions );
	}
	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'cb'      => '<input type="checkbox" />',
			'name'    => __( 'Name', 'sp' ),
			'address' => __( 'Address', 'sp' ),
			'city'    => __( 'City', 'sp' )
		];
		return $columns;
	}
	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'name' => array( 'name', true ),
			'city' => array( 'city', false )
		);
		return $sortable_columns;
	}
	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
			'bulk-delete' => 'Delete'
		];
		return $actions;
	}
	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {
		global $wpdb;
		$this->_column_headers = $this->get_column_info();
		/** Process bulk action */
		$this->process_bulk_action();
		$per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
		$current_page = $this->get_pagenum();

		$sql   = "SELECT * FROM {$wpdb->prefix}customers where 1=1 ";
		$count = "SELECT COUNT(*) FROM {$wpdb->prefix}customers where 1=1 ";
		$where = '';

		if( isset($_REQUEST['s']) && $_REQUEST['s'] != '' ){
			$s = $_REQUEST['s'];
			$where .= "and ( name LIKE '%$s%' or city LIKE '%$s%' or address LIKE '%$s%' )";
		}

		if( isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'Filter' ){
			if( isset($_REQUEST['cat-filter']) && $_REQUEST['cat-filter'] != '' ){
				$filter = $_REQUEST['cat-filter'];
				$where .= " and name LIKE '%$filter%'";
			}
		}

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$where .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$where .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		$sql   .= $where;
		$count .= $where;

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $current_page - 1 ) * $per_page;

		$result['items'] = $wpdb->get_results( $sql, 'ARRAY_A' );
		$total_items = $wpdb->get_var( $count );

		$this->items = $result['items'];
		$total_items = $total_items;
		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );
	}

	public function process_bulk_action() {
		$url = 'admin.php?page='.Customers_List::PLUGIN_SLUG;
		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {
			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );
			if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_customer( absint( $_REQUEST['customer'] ) );
                $page = isset($_REQUEST['paged'])?$_REQUEST['paged']:1;
                if( isset($_REQUEST['s']) && $_REQUEST['s'] !='' ){
                	$url .= '&s='.$_REQUEST['s'];
                }
				if( isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] = 'Filter' ){
					if( isset($_REQUEST['cat-filter']) && $_REQUEST['cat-filter'] != '' ){
						$url = '&filter_action=Filter&cat-filter='.$_REQUEST['cat-filter'];
					}
				}
                if($page > 1){
                	$url .= '&paged='.$page;
                }
                $url .= '&id='.$_REQUEST['customer'];
                wp_redirect( esc_url_raw(admin_url($url)) );
				exit();
			}
		}
		// If the delete bulk action is triggered
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'bulk-delete' || isset( $_REQUEST['action2'] ) && $_REQUEST['action2'] == 'bulk-delete' ) {
			$delete_ids = esc_sql( $_REQUEST['bulk-delete'] );
			// loop over the array of record IDs and delete them
			$count = count($delete_ids);
			foreach ( $delete_ids as $id ) {
				echo $id;
				self::delete_customer( $id );
			}
			$page = isset($_GET['paged'])?$_GET['paged']:1;
			if( isset($_REQUEST['s']) && $_REQUEST['s'] !='' ){
            	$url .= '&s='.$_REQUEST['s'];
            }
			if( isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] = 'Filter' ){
				if( isset($_REQUEST['cat-filter']) && $_REQUEST['cat-filter'] != '' ){
					$url = '&filter_action=Filter&cat-filter='.$_REQUEST['cat-filter'];
				}
			}
            if($page > 1){
            	$url .= '&paged='.$page;
            }
			$url .= '&ids='.$count;
			wp_redirect( esc_url_raw(admin_url($url)) );
			exit();
		}
	}

	public function extra_tablenav( $which ) {
	    global $wpdb, $testiURL, $tablename, $tablet;
	    if ( $which == "top" ){
	        //The code that goes before the table is there
	    }
	    if ( $which == "bottom" ){
	        //The code that goes after the table is there
	    }
        $views = $this->get_views();
        if ( empty( $views ) ) return;
        $this->views();
	}

	public function get_views() {
	    $status_links = array(
	        "all"       => __("<a href='#' class='current'>All(20)</a>",'my-plugin-slug'),
	        "filter1"   => __("<a href='#'>Hùng</a>",'my-plugin-slug'),
	        "filter2"   => __("<a href='#'>Thành</a>",'my-plugin-slug')
	    );
	    return $status_links;
	}

	public function display_tablenav( $which ) { ?>
        <?php $this->extra_tablenav( $which ); ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">

            <div class="alignleft actions">
                <?php $this->bulk_actions( $which ); ?>
            </div>

            <?php $this->pagination( $which ); ?>

            <?php $this->filter_action($which); ?>

            <br class="clear" />

        </div>
        <?php
    }

    public function filter_action($which){

    	$filter = '';

    	if( isset($_REQUEST['cat-filter']) && $_REQUEST['cat-filter'] != '' ){
    		$filter = $_REQUEST['cat-filter'];
    	}

    	if ( $which == "top" ){ ?>
	        <div class="alignleft actions">
			    <select name="cat-filter" class="ewc-filter-cat">
			    	<option value="">All</option>
			    	<option <?php echo $filter=='Hùng'?'selected':'' ?> value="Hùng">Hùng</option>
			    	<option <?php echo $filter=='Thành'?'selected':'' ?> value="Thành">Thành</option>
			    </select>
			    <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">
			</div>
	    <?php }
    }

    public function add_admin_notices(){
    	global $post_type, $pagenow;
    	$message = '';

    	if( $pagenow == 'admin.php' && ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'wp_list_table_class' && isset($_REQUEST['id']) ) ) {
    		$message = 'Item deleted.';
    	}

    	//Delete multi item
		if( $pagenow == 'admin.php' && ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'wp_list_table_class' && isset($_REQUEST['ids']) ) ) {
			$message = sprintf( _n( 'Deleted.', '%s item deleted.', (int) $_REQUEST['ids'] ), number_format_i18n( $_REQUEST['ids'] ) );
		}

		if( $message != '' ){
			echo "<div class=\"updated\"><p>".$message."</p></div>";
		}
    }

    public function search_box( $text, $input_id ) {
		// if ( empty( $_REQUEST['s'] ) && !$this->has_items() ) return;
		$input_id = $input_id . '-search-input';
		if ( ! empty( $_REQUEST['orderby'] ) )
			echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
		if ( ! empty( $_REQUEST['order'] ) )
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		if ( ! empty( $_REQUEST['post_mime_type'] ) )
			echo '<input type="hidden" name="post_mime_type" value="' . esc_attr( $_REQUEST['post_mime_type'] ) . '" />';
		if ( ! empty( $_REQUEST['detached'] ) )
			echo '<input type="hidden" name="detached" value="' . esc_attr( $_REQUEST['detached'] ) . '" />';
		?>
		<p class="search-box">
			<label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
			<input type="search" id="<?php echo $input_id ?>" name="s" value="<?php _admin_search_query(); ?>" />
			<?php submit_button( $text, 'button', false, false, array('id' => 'search-submit') ); ?>
		</p>
		<?php
	}

}
class SP_Plugin {
	const PLUGIN_SLUG = "wp_list_table_class";
	// class instance
	static $instance;
	// customer WP_List_Table object
	public $customers_obj;
	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 1 );
		add_action( 'admin_menu', [ $this, 'plugin_menu' ] );
		add_action( 'admin_notices', array( 'Customers_List', 'add_admin_notices' ) );
	}

	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	/**
	 * Admin menu
	 * @return [type] [description]
	 */
	public function plugin_menu() {
		$hook = add_menu_page(
			'Sitepoint WP_List_Table Example',//title
			'SP WP_List_Table',//menu name
			'manage_options',
			SP_Plugin::PLUGIN_SLUG,//slug
			[ $this, 'plugin_settings_page' ]//calback function
		);
		add_action( "load-$hook", [ $this, 'screen_option' ] );
	}

	/**
	 * Plugin settings page
	 */
	public function plugin_settings_page() { ?>
		<div class="wrap">
			<h1 class="wp-heading-inline">WP_List_Table Class Example</h1>
			<a href="<?php echo admin_url('admin.php?page='.SP_Plugin::PLUGIN_SLUG.'') ?>" class="page-title-action">Add New</a>

			<?php
				if( isset($_REQUEST['s']) && $_REQUEST['s'] != '' ){
					echo "<span class=\"subtitle\">Search results for “".$_REQUEST['s']."”</span>";
				}
			 ?>

			<hr class="wp-header-end">

			<div id="posts-filter">
				<div id="post-body" class="metabox-holder">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="get">
								<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']) ?>"/>
								<?php $this->customers_obj->search_box('search', 'search_id'); ?>
								<?php $this->customers_obj->prepare_items(); ?>
								<?php $this->customers_obj->display(); ?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
		<?php
	}

	/**
	 * Screen options
	 */
	public function screen_option() {
		$option = 'per_page';
		$args   = [
			'label'   => 'Customers',
			'default' => 5,
			'option'  => 'customers_per_page'
		];
		add_screen_option( $option, $args );
		$this->customers_obj = new Customers_List();
	}

	/** Singleton instance */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

add_action( 'plugins_loaded', function () {
	SP_Plugin::get_instance();
} );



/**
 * Add filter link
 *
add_filter('views_toplevel_page_wp_list_table_class','my_plugin_slug_status_links',10, 1);
function my_plugin_slug_status_links($views) {
   $views['scheduled'] =  "<a href='#'>Scheduled</a>";
   return $views;
}
*/


add_action('init', 'app_output_buffer1');
function app_output_buffer1() {
	ob_start();
} // soi_output_buffer