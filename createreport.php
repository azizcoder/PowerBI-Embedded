<?php
include 'flightstats.php';
include 'header.php'; ?>

<div id="reportContainer"></div>
<script>


// Get models. models contains enums that can be used.


var models = window['powerbi-client'].models;


// Embed configuration used to describe the what and how to embed.


// This object is used when calling powerbi.embed.


// This also includes settings and options such as filters.


// You can find more information at https://github.com/Microsoft/PowerBI-JavaScript/wiki/Embed-Configuration-Details.


var embedCreateConfiguration= {


type: 'report',


datasetId: ' ', // dataset ID


embedUrl: "<?php echo $embedUrl ?>",


accessToken: "<?php echo $token; ?>" ,


};


var $embedContainer = $('#reportContainer');


// Create report
var report = powerbi.createReport($embedContainer.get(0), embedCreateConfiguration);

// Report.off removes a given event handler if it exists.
report.off("loaded");

// Report.on will add an event handler which prints to Log window.
report.on("loaded", function() {
    Log.logText("Loaded");
});

report.off("error");
report.on("error", function(event) {
    Log.log(event.detail);
});

// report.off removes a given event handler if it exists.
report.off("saved");
report.on("saved", function(event) {
    Log.log(event.detail);
    Log.logText('In order to interact with the new report, create a new token and load the new report');
});


</script>


</body>

</html>
