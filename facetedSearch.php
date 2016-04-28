<?php
include('header.php');
?>
<div ng-app="firstApp" ng-controller="MainCtrl">
    <solr docs="docs" num-found="numFound" solr-url="'http://dev2.toeska.cl/solr/encuentros/query?json.wrf=JSON_CALLBACK'">
        <div class="row">
            <div class="span3">
                <solr-facet-group>
                    <h4>Busqueda:</h4>
                    <solr-search preload='true' query='{{params.q}}'></solr-search>
                    <solr-selected><h4>Seleccionado:</h4></solr-selected>
                    <h4>Facetas:</h4>
                    <solr-facet display="Hora" field="hora"></solr-facet>
                    <solr-facet display="Tipo" field="tipo_encuentro"></solr-facet>
                    <solr-facet display="Fuente" field="fuente"></solr-facet>
                    <solr-facet display="Duración" field="duracion"></solr-facet>
                    <solr-facet display="Localización" field="microlocalizacion"></solr-facet>
                </solr-facet-group>
            </div>

            <div class="span7">
                <h4>Resultados ({{numFound}})</h4>
                <ul class="list-unstyled">
                    <li ng-repeat="doc in docs">
                        <result-document record=doc ></result-document>
                    </li>
                </ul>
            </div>
        </div>
    </solr>
</div>
<script src="angular-solr/bower_components/angular/angular.js"></script>
<script src="angular-solr/js/solr.js" type="text/javascript" charset="utf-8"></script>
<script src="angular-solr/js/moai.js" type="text/javascript" charset="utf-8"></script>
<?php
include('footer.html');
?>
