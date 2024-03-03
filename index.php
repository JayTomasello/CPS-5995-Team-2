<?php
include('header.php');
?>

<?php
if (!isset($_COOKIE['signedIn']) && ($_SESSION['agree'] !== TRUE)) {
    echo ('<div id="popup-box" class="z-3 position-absolute top-50 start-50 translate-middle p-4 rounded-3" style="background-color:beige">
            <h1>DISCLAIMER</h1>
            <p>The content presented on Legal Digest 4 New Jersey should not be construed as legal advice and is not meant to serve as such. Rather, all materials, content, and information provided here are intended for general informational purposes only.</p><br>


            <p>Visitors to Legal Digest 4 New Jersey are encouraged to consult with their attorney regarding any specific legal concerns they may have. It is advised that no individual accessing this site should make decisions or abstain from actions solely based on the information provided here without first seeking guidance from legal counsel in the appropriate jurisdiction.</p><br>


            <p>Please be aware that the information on Legal Digest 4 New Jersey may not contain the most current or up-to-date legal information, as it is updated on a weekly basis resulting in a delay.</p><br>


            <p>Additionally, this website includes links to the official website of the New Jersey Office of Legislative Services to make unaltered bill information available for reference. The accuracy of any other information found on this website is not guaranteed.
            </p><br>
            <h1>TERMS AND CONDITIONS</h1>
            <p>By accepting this agreement and using this website, you agree that you have read and understand the above disclaimer. The owners, operators, and stakeholders of this website are in no way responsible for any actions taken or damages resulting from referring to the information on Legal Digest 4 New Jersey.

            </p><br>
            <button id="agree-btn" class="btn btn-primary mx-2"><a class="text-white" href="session_agree.php">Agree</a></button>
            <button id="disagree-btn" class="btn btn-primary mx-2"><a class="text-white" href="disclaimer.php">Disagree</a></button>
        </div>');
}
?>

<div class="d-flex justify-content-evenly vh-100" style="background-color: rgb(170, 159, 91)">


    <!-- AI Lawyer -->

    <div class="col-4 h-auto d-inline-block my-4 rounded-5 border-3" style="background-color:white">
        <?php
        if (!isset($_COOKIE['signedIn'])) {
            echo ('<div class"position-relative w-100 h-100 opacity-50 bg-black"></div>');
        }
        ?>
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