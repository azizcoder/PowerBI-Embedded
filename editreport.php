<?php
include 'pbi-logic.php';
include 'header.php'; ?>

<div id="reportContainer"></div>

<script>


// Get models. models contains enums that can be used.


var models = window['powerbi-client'].models;


// Embed configuration used to describe the what and how to embed.


// This object is used when calling powerbi.embed.


// This also includes settings and options such as filters.


// You can find more information at https://github.com/Microsoft/PowerBI-JavaScript/wiki/Embed-Configuration-Details.


var embedConfiguration= {


type: 'report',


id: ' ', // Power BI report ID


embedUrl: "<?php echo $embedUrl ?>",


accessToken: "<?php echo $token; ?>" ,

permissions: models.Permissions.All /*gives maximum permissions*/,
    viewMode: models.ViewMode.Edit,
    settings: {
        filterPaneEnabled: true,
        navContentPaneEnabled: true
    }

};


var $reportContainer = $('#reportContainer');


var report = powerbi.embed($reportContainer.get(0), embedConfiguration);


</script>
</body>
</html>
