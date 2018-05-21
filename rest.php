<?php
include 'pbi-logic.php';
include 'header.php'; ?>

<h1> Power BI REST calls raw output:<br></h1>




AAD response dump :<br><pre> <?php echo json_encode($tokenResult,JSON_PRETTY_PRINT); ?></pre>

<br><br>



Power BI token dump:<pre> <?php echo json_encode($embedResponse,JSON_PRETTY_PRINT); ?></pre>



</body>

</html>
