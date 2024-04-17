<?php
include('header.php');

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
            <div class='justify-content-between col-4 w-100' style='background-color: white'>

            <div class='d-flex w-100 m-3 justify-content-evenly'>
                <input class='col-8 input-group-text text-light rounded-5' placeholder='Anything I can clear up for you?'>
                <img class='img' src='./robot lawyer.png' style='width:100px;'>
            </div>

            <div class='rounded-5 h-75 text-dark text-wrap m-2 p-3' style='background-color: lightgrey'>
                Hello!  I am the AI Lawyer.  I can help you with any legal questions you may have.  Please enter your question above and I will do my best to help you.
            </div>
        </div>
            ");
        }
        ?>
    </div>

    <!-- Document Viewer -->
    <div class="d-inline-flex col-8 p-4">
        <div class="w-100 bg-white rounded-5 p-2">

            <!-- TOP FORM -->
            <div name="title_bar" class="d-flex flex-row mb-3 bg-secondary rounded-5 p-3 align-items-center justify-content-evenly">
                <p class="fs-2 text-light" name="search_result_title">Legislative Summary Viewer</p>
                <?php
                if (isset($_GET['subject_search'])) {
                ?>
                    <form class="d-flex" name="filter_by_session" method="GET">
                        <label class="fs-5 text-light" for="session-filter">Filter by Session:</label>
                        <select class="form-select" name="session-filter" id="session-filter" default="All Sessions">
                            <option value="">Choose Session</option>
                            <?php
                            $query = "SELECT DISTINCT session FROM law_table2 ORDER BY session DESC";
                            $result = pg_query($conn, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo ("<option value='" . $row['session'] . "'>" . $row['session'] . "</option>");
                            }
                            if (isset($_GET['subject_search'])) {
                                $subject_search = $_GET['subject_search'];
                            }
                            ?>
                        </select>
                        <input type="hidden" name="subject_search" value="<?php echo $subject_search; ?>">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </form>
                <?php
                }
                ?>
            </div>

            <!-- SEARCH RESULTS -->
            <div name="search_results" class="bg-secondary h-75 overflow-auto">
                <?php
                // if (isset($_COOKIE['email'])) {
                // Default Results For Signed In User
                if (isset($_GET['subject_search']) && isset($_GET['session-filter'])) {

                    $subject_search = $_GET['subject_search'];
                    $session_filter = $_GET['session-filter'];
                    $subject_search = str_replace('_', ' ', $subject_search);
                    $query = "SELECT * FROM law_table2 WHERE bill_summary is not NULL AND session='$session_filter' AND subject='$subject_search' LIMIT 100";
                    $result = pg_query($conn, $query);
                    if ($result) {
                        if (pg_num_rows($result) > 0) {
                            echo "<br><h2 class='text-center' style='color:white;'>Search results for Subject: $subject_search and Session: $session_filter</h2>";
                            echo ('<div class="accordion accordion-flush m-3 rounded-4" id="view_bills">');
                            $i = 0;
                            while ($row = pg_fetch_assoc($result)) {
                                $bill_number = $row['bill_number'];
                                $bill_url = $row['bill_url'];
                                $session = $row['session'];
                                $subject = $row['subject'];
                                $bill_synopsis = $row['bill_synopsis'];
                                $summary = $row['bill_summary'];

                                echo '<div class="accordion-item">';
                                echo '<h2 class="accordion-header">';
                                echo '<button class="accordion-button collapsed justify-content-evenly" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $i . '" aria-expanded="false" aria-controls="collapse' . $i . '">';
                                echo '<strong>Year: ' . $session . ' | Subject: ' . $subject . ' | Bill Number: ' . $bill_number;
                                echo '<br><br>Synopsis: ' . $bill_synopsis . '</strong>';
                                echo '</button>';
                                echo '</h2>';
                                echo '<div id="collapse' . $i . '" class="accordion-collapse collapse" data-bs-parent="#view-bills">';
                                echo '<div class="accordion-body">';
                                echo ('<h3 class="text-dark"><a href="' . $bill_url . '">View the Source Doc</a></h3>');
                                echo "<h4 class='text-center'>Summary of the Bill</h4>";
                                echo ('<p class="text-dark">' . $summary . '</p>');
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $i++;
                            }
                            echo ("</div>");
                        } else {
                            echo "<br><h2 class='text-center' style='color:white;'>There are no bills currently in the system matching your selected filters:<br> Subject: $subject_search and Session: $session_filter</h2";
                        }
                    }
                } else {
                    if (isset($_GET['subject_search'])) {
                        echo "<br><h2 class='text-center' style='color:white;'>Please select a legislative session (year) to search for.</h2>";
                    } else {
                        echo "<br><h2 class='text-center' style='color:white;'>Please select a legislative subject to search for.</h2>";
                    }
                }
                // } else {
                //     // Default Results For Guest User
                //     // $query = "SELECT MAX(session) FROM dummy_table2";
                //     // $result = pg_query($conn, $query);
                //     // $most_recent_session = pg_fetch_assoc($result)['max'];

                //     // Retrieve all documents from the most recent session year
                //     // $query = "SELECT * FROM dummy_table2 WHERE session = '$most_recent_session' AND bill_summary is not NULL LIMIT 100";
                //     $query = "SELECT * FROM law_table2 WHERE bill_summary is not NULL LIMIT 100";

                //     $result = pg_query($conn, $query);
                //     if ($result) {
                //         if (pg_num_rows($result) > 0) {
                //             echo ('<div class="accordion accordion-flush m-3 rounded-4" id="view_bills">');
                //             $i = 0;
                //             while ($row = pg_fetch_assoc($result)) {
                //                 $bill_number = $row['bill_number'];
                //                 $bill_url = $row['bill_url'];
                //                 $session = $row['session'];
                //                 $subject = $row['subject'];
                //                 $bill_synopsis = $row['bill_synopsis'];
                //                 $summary = $row['bill_summary'];

                //                 echo '<div class="accordion-item">';
                //                 echo '<h2 class="accordion-header">';
                //                 echo '<button class="accordion-button collapsed justify-content-evenly" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $i . '" aria-expanded="false" aria-controls="collapse' . $i . '">';
                //                 echo '<strong>Year: ' . $session . ' | Subject: ' . $subject . ' | Bill Number: ' . $bill_number;
                //                 echo '<br><br>Synopsis: ' . $bill_synopsis . '</strong>';
                //                 echo '</button>';
                //                 echo '</h2>';
                //                 echo '<div id="collapse' . $i . '" class="accordion-collapse collapse" data-bs-parent="#view-bills">';
                //                 echo '<div class="accordion-body">';
                //                 echo ('<h3 class="text-dark"><a href="' . $bill_url . '">View the Source Doc</a></h3>');
                //                 echo "<h4 class='text-center'>Summary of the Bill</h4>";
                //                 echo ('<p class="text-dark">' . $summary . '</p>');
                //                 echo '</div>';
                //                 echo '</div>';
                //                 echo '</div>';
                //                 $i++;
                //             }
                //             echo ("</div>");
                //         }
                //     }
                // }
                ?>
            </div>

            <script>
                // Add event listener to the "View" buttons for each bill
                var viewButtons = document.getElementsByClassName('select_a_bill');
                for (var i = 0; i < viewButtons.length; i++) {
                    viewButtons[i].addEventListener('click', function() {});
                }
            </script>

        </div>
    </div>


</div>

</body>

</html>