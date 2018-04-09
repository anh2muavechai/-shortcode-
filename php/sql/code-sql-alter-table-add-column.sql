ALTER TABLE mytable ADD COLUMN mycolumn character varying(50) NOT NULL DEFAULT 'foo';

ALTER TABLE <tablename> RENAME <oldcolumn> TO <newcolumn>;
ALTER TABLE <tablename> ALTER COLUMN <columnname> TYPE <newtype>;