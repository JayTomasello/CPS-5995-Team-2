<?php
include('header.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pop-up Box</title>
    <style>
        /* Styles for the overlay */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            /* Ensure the overlay is below the pop-up box */
        }

        /* Styles for the pop-up box */
        #popup-box {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            z-index: 9999;
        }

        /* Styles for the buttons */
        #popup-box button {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div id="overlay" class="z-2" style="background-color: rgba(0, 0, 0, 0.5)"></div>

    <div id="popup-box" class="z-3" style="background-color: white">
        <h1>DISCLAIMER</h1>
        <p>The content presented on Legal Digest 4 New Jersey should not be construed as legal advice and is not meant to serve as such. Rather, all materials, content, and information provided here are intended for general informational purposes only.</p><br>


        <p>Visitors to Legal Digest 4 New Jersey are encouraged to consult with their attorney regarding any specific legal concerns they may have. It is advised that no individual accessing this site should make decisions or abstain from actions solely based on the information provided here without first seeking guidance from legal counsel in the appropriate jurisdiction.</p><br>


        <p>Please be aware that the information on Legal Digest 4 New Jersey may not contain the most current or up-to-date legal information, as it is updated on a weekly basis resulting in a delay.</p><br>


        <p>Additionally, this website includes links to the official website of the New Jersey Office of Legislative Services to make unaltered bill information available for reference. The accuracy of any other information found on this website is not guaranteed.
        </p><br>
        <h1>TERMS AND CONDITIONS</h1>
        <p>By accepting this agreement and using this website, you agree that you have read and understand the above disclaimer. The owners, operators, and stakeholders of this website are in no way responsible for any actions taken or damages resulting from referring to the information on Legal Digest 4 New Jersey.

        </p><br>
        <button id="agree-btn" class="btn btn-primary mx-2">Agree</button>
        <button id="disagree-btn" class="btn btn-primary mx-2">Disagree</button>
    </div>

    <script>
        // Get the overlay, pop-up box, and buttons
        var overlay = document.getElementById('overlay');
        var popupBox = document.getElementById('popup-box');
        var agreeBtn = document.getElementById('agree-btn');
        var disagreeBtn = document.getElementById('disagree-btn');

        // Function to close the pop-up box and overlay
        function closePopupBox() {
            popupBox.style.display = 'none';
            overlay.style.display = 'none';
        }

        // Function to redirect to another page
        function redirectToAnotherPage() {
            window.location.href = 'disclaimer.php';
        }

        // Event listener for the Agree button
        agreeBtn.addEventListener('click', function() {
            closePopupBox();
        });

        // Event listener for the Disagree button
        disagreeBtn.addEventListener('click', function() {
            redirectToAnotherPage();
        });

        // Display the overlay and pop-up box on page load
        window.onload = function() {
            overlay.style.display = 'block';
            popupBox.style.display = 'block';
        };
    </script>


    <div class="d-flex justify-content-evenly" style="height:88vh; background-color: rgb(170, 159, 91)">

        <!-- AI Lawyer -->
        <div class="col-4 h-auto d-inline-block my-4 rounded-5 border-3 <?php if (!isset($_COOKIE['signedIn'])) {
                                                                            echo ('opacity-50');
                                                                        } ?>" style="background-color:white">
            <div class="h-100 m-1 rounded-5" style="background-color: rgb(80, 104, 148);">
                <div class="d-inline-flex m-4">
                    <input class="col-12 input-group-text rounded-5 disabled" placeholder="Ask our robot lawyer...">
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