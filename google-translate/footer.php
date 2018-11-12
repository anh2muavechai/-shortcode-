<li class="info-list">
		<ul class="translation-links">
			<li style="display: inline-block;">
				<a href="javascript:void(0)" class="flag vn" data-lang="Tiếng Việt" data-lang2="Vietnamese"><img src="http://xenang-yale-forklift.com/wp-content/uploads/2018/07/vn.png"></a>
			</li>
			<li style="display: inline-block;">
				<a href="javascript:void(0)" class="flag en" data-lang="Tiếng Anh" data-lang2="English"><img src="http://xenang-yale-forklift.com/wp-content/uploads/2018/07/en.png"></a>
			</li>
		</ul>
		<div id="google_translate_element" style="display: none"></div>
	</li>


	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'vi',
            includedLanguages: 'vi,en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.translation-links a').click(function() {
            var lang = jQuery(this).data('lang');
            var lang2 = jQuery(this).data('lang2');
            var jQueryframe = jQuery('.goog-te-menu-frame:first');
            if (!jQueryframe.size()) {
                alert("Error: Could not find Google translate frame.");
                return false;
            }
            // console.log(jQueryframe.contents().find('.goog-te-menu2-item span.text:contains('+lang+')'));
            if(jQueryframe.contents().find('.goog-te-menu2-item span.text:contains('+lang+')').length == 0){
            	jQueryframe.contents().find('.goog-te-menu2-item span.text:contains('+lang2+')').get(0).click();
            }else{
            	jQueryframe.contents().find('.goog-te-menu2-item span.text:contains('+lang+')').get(0).click();
            }

            return false;
        });
    })
</script>