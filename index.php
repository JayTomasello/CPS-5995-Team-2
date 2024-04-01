<?php
include('header.php');
?>

<?php
if ((!isset($_COOKIE['email'])) && ((!isset($_SESSION['agree'])) || ($_SESSION['agree'] == FALSE))) {
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

<div class="d-flex vh-100" style="background-color: rgb(170, 159, 91)">

    <div class="d-flex col-4">
        <!-- AI Lawyer -->
        <?php
        if (!isset($_COOKIE['email'])) {
            echo ("
        <div class='justify-content-between col-4 w-100 disabled' style='background-color: lightgrey'>

            <div class='d-flex w-100 m-3 justify-content-evenly'>
                <input class='col-8 input-group-text text-light rounded-5 disabled' placeholder='Login/Register as a Subscribed User'>
                <img class='img disabled' src='./robot lawyer.png' style='width:100px;'>
            </div>

            <div class='rounded-5 disabled h-75 text-light text-wrap m-2 p-3' style='background-color: grey'>
                Please login or sign up to use our robo-lawyer!
            </div>
        </div>
        ");
        } else {
            echo ("
            <div class='justify-content-between col-4 w-100 disabled' style='background-color: lightgrey'>

            <div class='d-flex w-100 m-3 justify-content-evenly'>
                <input class='col-8 input-group-text text-light rounded-5 disabled' placeholder='Login/Register as a Subscribed User'>
                <img class='img disabled' src='./robot lawyer.png' style='width:100px;'>
            </div>

            <div class='rounded-5 disabled text-light text-wrap m-2 p-3' style='background-color: grey'>
            </div>
            </div>
            ");
        }
        ?>
    </div>

    <!-- Document Viewer -->
    <div class="d-inline-flex col-8 p-4">
        <div class="w-100 bg-white rounded-5 p-4">
            <div class="bg-secondary rounded-5 p-3 d-flex flex-column align-items-stretch">
                <h1 name="search_result_title">Document Viewer</h1>
                <form name="filter_by_session" method="GET" action="">
                    <label for="session-filter">Filter by Session:</label>
                    <select name="session-filter" id="session-filter">
                        <option value="">All Sessions</option>
                        <option value="session1">Session 1</option>
                        <option value="session2">Session 2</option>
                        <option value="session3">Session 3</option>
                        <!-- Add more options as needed -->
                    </select>
                    <button type="submit">Filter</button>
                </form>
            </div>
            <div name="search_result_list" class="container">

            </div>

        </div>
    </div>


</div>

</body>

</html>