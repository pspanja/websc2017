#!/bin/bash

cp /var/www/html/summercamp/ezsolr/vendor/ezsystems/ezplatform-solr-search-engine/lib/Resources/config/solr/schema.xml /var/solr/data/collection1/conf/
cp /var/www/html/summercamp/ezsolr/vendor/ezsystems/ezplatform-solr-search-engine/lib/Resources/config/solr/solr.languages/en/language-fieldtypes.xml /var/solr/data/collection1/conf/
cp /var/www/html/summercamp/ezsolr/vendor/ezsystems/ezplatform-solr-search-engine/lib/Resources/config/solr/solr.languages/en/stopwords_en.txt /var/solr/data/collection1/conf/
touch /var/solr/data/collection1/conf/protwords.txt
rm /var/solr/data/collection1/conf/managed-schema
