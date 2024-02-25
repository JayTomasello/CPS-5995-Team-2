<?php
include('header.php');
?>

<body>

    <div class="d-flex justify-content-evenly" style="height:88vh; background-color: rgb(170, 159, 91)">

        <!-- Robo Lawyer Section -->
        <div class="col-4 h-auto d-inline-block my-4 rounded-5 border-3" style="background-color:white">
            <div class="h-100 m-1 rounded-5" style="background-color: rgb(80, 104, 148);">
                <div class="d-inline-flex m-4">
                    <input class="col-12 input-group-text rounded-5" placeholder="Ask our robot lawyer...">
                    <img class="img mx-5" src="./robot lawyer.png" style="width:100px;">
                </div>
                <div class="m-4 p-3 h-75 rounded-5" style="background-color:white">
                    AI Lawyer Response
                </div>
            </div>

        </div>

        <!-- Document Viewer -->
        <div class="col-7 h-auto d-inline-block mt-5 m-1 rounded-5 border-3" style="background-color:white">
            <div class="h-100 rounded-5 m-1" style="background-color: rgb(80, 104, 148);">
                <div class="m-4 p-3 h-75 rounded-5 my-3" style="background-color:white">Source Documents and Summaries</div>
            </div>
        </div>

    </div>

</body>

</html>