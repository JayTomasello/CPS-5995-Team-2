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

<div class="d-flex vh-20" style="background-color: rgb(170, 159, 91)">

    <!-- AI Lawyer -->
    <?php
    if (!isset($_COOKIE['email'])) {
        echo ("
            <div class='justify-content-between col-4 w-100 disabled' style='background-color: rgb(170, 159, 91)'>
                <div class='d-flex w-100 m-3 justify-content-evenly'>
                    <div class='rounded-5 disabled h-75 text-light text-wrap m-2 p-3' style='background-color: grey'>
                        Please login or sign up to use our legislative bill Q&A feature!
                        <img class='img disabled' src='./robot lawyer.png' style='width:50px; margin-left: 10px; height:50px'>
                    </div>
                </div>
            </div>
        ");
    } else if (isset($_GET['subject_search']) && isset($_GET['bill_session']) && isset($_COOKIE['email']) && isset($_GET['bill_number']) && !isset($_GET['user_question'])) {
        echo "<div class='d-flex col-4'>";
        echo "<form class='justify-content-between col-4 w-100' action='' method='GET'>";
        echo "
            <div class='justify-content-between col-4 w-100'>

            <div class='d-flex w-100 m-3 justify-content-evenly'>
                <input class='col-8 input-group-text rounded-5' id='user_question' name='user_question' placeholder='Anything I can clear up for you?'>
                <img class='img' src='./robot lawyer.png' style='width:80px; height:80px;'>
            </div>

            <div class='rounded-5 h-75 text-dark text-wrap m-2 p-3' style='background-color: lightgrey'>
                Hello!  I am the AI Lawyer.  I can help you with any legal questions you may have.  Please enter your question above and I will do my best to help you.<br><br>";
        $subject_search = $_GET['subject_search'];
        $session_filter = $_GET['bill_session'];
        $bill_number2 = $_GET['bill_number'];

        $session_link = "";
        $session_link = isset($_GET['session_link']) ? $_GET['session_link'] : '';
        if (!empty($session_link)) {
            echo "<input type='hidden' id='session_link' name='session_link' value='$session_link'>";
        }

        $search_link = "";
        $search_link = isset($_GET['search_link']) ? $_GET['search_link'] : '';
        if (!empty($session_link)) {
            echo "<input type='hidden' id='search_link' name='search_link' value='$search_link'>";
        }

        echo "<input type='hidden' id='subject_search' name='subject_search' value='$subject_search'>";
        echo "<input type='hidden' id='bill_session' name='bill_session' value='$session_filter'>";
        echo "<input type='hidden' id='bill_number' name='bill_number' value='$bill_number2'>";
        echo "<center><button name='Question' type='submit' value='submit' class='btn btn-primary'>Submit Question</button></center></form>";
        echo "
            </div>
        </div>
            ";
    } else if (isset($_GET['subject_search']) && isset($_GET['bill_session']) && isset($_COOKIE['email']) && isset($_GET['bill_number']) && isset($_GET['user_question'])) {
        echo "<div class='d-flex col-4'>";
        $subject_search = $_GET['subject_search'];
        $subject_search = str_replace(" ", "~~~", $subject_search);
        $session_filter = $_GET['bill_session'];
        $bill_number2 = $_GET['bill_number'];
        $user_question = $_GET['user_question'];
        $user_question = str_replace(" ", "~~~", $user_question);
        $command = "python billQuestion.py " . $bill_number2 . " " . $session_filter . " " . $subject_search . " " . $user_question;
        exec($command, $output, $return_var);
        if (isset($output[0])) {
            $answer_text = $output[0];
        } else {
            $answer_text = "Sorry, this question cannot be answered at this time.";
        }
        echo "<form class='justify-content-between col-4 w-100' action='' method='GET'>";
        echo "
            <div class='justify-content-between col-4 w-100'>

            <div class='d-flex w-100 m-3 justify-content-evenly'>
                <input class='col-8 input-group-text rounded-5' id='user_question' name='user_question' placeholder='Anything I can clear up for you?'>
                <img class='img' src='./robot lawyer.png' style='width:80px; height:80px;'>
            </div>

            <div class='rounded-5 h-75 text-dark text-wrap m-2 p-3' style='background-color: lightgrey'>
            <h4 style='text-align:center'>Response</h4>
            $answer_text<br><br>";
        $subject_search = $_GET['subject_search'];
        $session_filter = $_GET['bill_session'];
        $bill_number2 = $_GET['bill_number'];

        $session_link = "";
        $session_link = isset($_GET['session_link']) ? $_GET['session_link'] : '';
        if (!empty($session_link)) {
            echo "<input type='hidden' id='session_link' name='session_link' value='$session_link'>";
        }

        $search_link = "";
        $search_link = isset($_GET['search_link']) ? $_GET['search_link'] : '';
        if (!empty($session_link)) {
            echo "<input type='hidden' id='search_link' name='search_link' value='$search_link'>";
        }

        echo "<input type='hidden' id='subject_search' name='subject_search' value='$subject_search'>";
        echo "<input type='hidden' id='bill_session' name='bill_session' value='$session_filter'>";
        echo "<input type='hidden' id='bill_number' name='bill_number' value='$bill_number2'>";
        echo "<center><button name='Question' type='submit' value='submit' class='btn btn-primary'>Submit Question</button></center></form>";
        echo "
            </div>
        </div>
            ";
    } else {
        
    }
    ?>
</div>

<!-- Document Viewer -->

    <!-- TOP FORM -->
        <?php
        if (isset($_GET['subject_search'])) {
        ?>
        <div class="bg-white rounded-5 p-4" style="margin:30px;">
        <div name="title_bar" class="d-flex flex-row mb-3 bg-secondary rounded-5 p-2 align-items-center justify-content-evenly">
        <p class="fs-2 text-light" name="search_result_title" style="margin:20px">Legislative Summary Viewer</p>
            <form class="d-flex" name="filter_by_session" method="GET">
                <label class="fs-5 text-light" for="session_filter">Filter by Session:</label>
                <select class="form-select" name="session_filter" id="session_filter" default="All Sessions">
                    <option value="">Choose Session</option>
                    <?php
                    $query = "SELECT DISTINCT session FROM law_table2 ORDER BY session DESC";
                    $result = pg_query($conn, $query);
                    while ($row = pg_fetch_assoc($result)) {
                        $next_session = (int)$row['session'] + 1;
                        echo ("<option value='" . $row['session'] . "'>" . $row['session'] . " - $next_session</option>");
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
    <div name="search_results" class="bg-secondary rounded-5 h-60 overflow-auto" style="margin:30px">
        <?php
        if (isset($_GET['subject_search']) && !isset($_COOKIE['email']) && !isset($_GET['bill_number'])) {

            $subject_search = $_GET['subject_search'];
            $subject_search = str_replace('_', ' ', $subject_search);
            $query = "SELECT * FROM law_table2 WHERE bill_summary is not NULL AND subject='$subject_search'";

            $session_filter = isset($_GET['session_filter']) ? $_GET['session_filter'] : '';
            if (!empty($session_filter)) {
                $session_filter = pg_escape_string($conn, $session_filter);
                $query .= " AND session='" . $session_filter . "'";
            }

            $search_terms = isset($_GET['search-terms']) ? $_GET['search-terms'] : '';
            if (!empty($search_terms)) {
                $search_terms = pg_escape_string($conn, $search_terms);
                $query .= " AND (bill_synopsis ILIKE '%$search_terms%' OR bill_summary ILIKE '%$search_terms%')";
            }

            $result = pg_query($conn, $query);
            if ($result) {
                if (pg_num_rows($result) > 0) {
                    echo "
                            <center><br><form class='d-inline-flex' name='filter_by_terms' method='GET'>
                                <label class='fs-5 text-light me-3' for='search-terms'>Search by Keywords:</label>
                                <input class='form-control me-3' style='width: 500px;' type='search' name='search-terms' placeholder='Enter keywords'>
                                <input type='hidden' name='subject_search' value='$subject_search''>
                                <input type='hidden' name='session_filter' value='$session_filter'>
                                <button class='btn btn-primary' type='submit'>Search</button>
                            </form></center>";
                    echo "<br><h2 class='text-center' style='color:white;'>SEARCH RESULTS</h2>";
                    echo "<h5 class='text-center' style='color:white;'>Subject: $subject_search</h5>";
                    if (isset($_GET['session_filter'])) {
                        if (!empty($session_filter)) {
                            echo "<h5 class='text-center' style='color:white;'>Session: $session_filter</h5>";
                        }
                    }

                    if (isset($_GET['search-terms'])) {
                        if (!empty($search_terms)) {
                            echo "<h5 class='text-center' style='color:white;'>Keyword(s): $search_terms</h5>";
                        }
                    }

                    echo ('<div class="accordion accordion-flush m-3 rounded-4" id="view_bills">');
                    $i = 0;
                    while ($row = pg_fetch_assoc($result)) {
                        $bill_number = $row['bill_number'];
                        $bill_url = $row['bill_url'];
                        $bill_synopsis = $row['bill_synopsis'];
                        $summary = $row['bill_summary'];
                        $bill_session = $row['session'];

                        echo '<div class="accordion-item">';
                        echo '<h2 class="accordion-header">';
                        echo '<button class="accordion-button collapsed justify-content-evenly" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $i . '" aria-expanded="false" aria-controls="collapse' . $i . '">';
                        echo '<p><b>Bill Number: ' . $bill_number . ' | Session: ' . $bill_session . '</b>';
                        echo '<br><br>Synopsis: ' . $bill_synopsis . '</p>';
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
                    echo "<br><h2 class='text-center' style='color:white;'>There are no bills currently in the system matching your selected filters.</h2>";
                }
            }
        } else if (isset($_GET['subject_search']) && isset($_COOKIE['email']) && !isset($_GET['bill_number'])) {
            $subject_search = $_GET['subject_search'];
            $subject_search = str_replace('_', ' ', $subject_search);
            $query = "SELECT * FROM law_table2 WHERE bill_summary is not NULL AND subject='$subject_search'";

            $session_link = "";
            $session_filter = isset($_GET['session_filter']) ? $_GET['session_filter'] : '';
            if (!empty($session_filter)) {
                $session_filter = pg_escape_string($conn, $session_filter);
                $query .= " AND session='" . $session_filter . "'";
                $session_link = $session_link . "&session_link=$session_filter";
            }

            $search_link = "";
            $search_terms = isset($_GET['search-terms']) ? $_GET['search-terms'] : '';
            if (!empty($search_terms)) {
                $search_terms = pg_escape_string($conn, $search_terms);
                $query .= " AND (bill_synopsis ILIKE '%$search_terms%' OR bill_summary ILIKE '%$search_terms%')";
                $search_link = $search_link . "&search_link=$search_terms";
            }

            $result = pg_query($conn, $query);
            if ($result) {
                if (pg_num_rows($result) > 0) {
                    echo "
                            <center><br><form class='d-inline-flex' name='filter_by_terms' method='GET'>
                                <label class='fs-5 text-light me-3' for='search-terms'>Search by Keywords:</label>
                                <input class='form-control me-3' style='width: 500px;' type='search' name='search-terms' placeholder='Enter keywords'>
                                <input type='hidden' name='subject_search' value='$subject_search''>
                                <input type='hidden' name='session_filter' value='$session_filter'>
                                <button class='btn btn-primary' type='submit'>Search</button>
                            </form></center>";
                    echo "<br><h2 class='text-center' style='color:white;'>SEARCH RESULTS</h2>";
                    echo "<h5 class='text-center' style='color:white;'>Subject: $subject_search</h5>";
                    if (isset($_GET['session_filter'])) {
                        if (!empty($session_filter)) {
                            echo "<h5 class='text-center' style='color:white;'>Session: $session_filter</h5>";
                        }
                    }

                    if (isset($_GET['search-terms'])) {
                        if (!empty($search_terms)) {
                            echo "<h5 class='text-center' style='color:white;'>Keyword(s): $search_terms</h5>";
                        }
                    }

                    echo ('<div class="accordion accordion-flush m-3 rounded-4" id="view_bills">');
                    $i = 0;
                    while ($row = pg_fetch_assoc($result)) {
                        $bill_number = $row['bill_number'];
                        $bill_url = $row['bill_url'];
                        $bill_synopsis = $row['bill_synopsis'];
                        $summary = $row['bill_summary'];
                        $bill_session = $row['session'];

                        echo '<div class="accordion-item">';
                        echo '<h2 class="accordion-header">';
                        echo '<button class="accordion-button collapsed justify-content-evenly" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $i . '" aria-expanded="false" aria-controls="collapse' . $i . '">';
                        echo '<p><b>Bill Number: ' . $bill_number . ' | Session: ' . $bill_session . '</b>';
                        echo '<br><br>Synopsis: ' . $bill_synopsis . '</p>';
                        echo '</button>';
                        echo '</h2>';
                        echo '<div id="collapse' . $i . '" class="accordion-collapse collapse" data-bs-parent="#view-bills">';
                        echo '<div class="accordion-body">';
                        echo ('<h3 class="text-dark"><a href="' . $bill_url . '">View the Source Doc</a></h3>');
                        echo "<h4 class='text-center'>Summary of the Bill</h4>";
                        echo ('<p class="text-dark">' . $summary . '</p>');
                        echo "<center><h4 class='text-dark'><a style='background-color: white;
                                color: black;
                                border: 2px solid blue;
                                padding: 10px 20px;
                                text-align: center;
                                text-decoration: none;
                                display: inline-block;' href='index.php?bill_session=$bill_session&subject_search=$subject_search&bill_number=$bill_number" . $session_link . $search_link . "'>Ask a question about this bill.</a></h4></center>";
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        $i++;
                    }
                    echo ("</div>");
                } else {
                    echo "<br><h2 class='text-center' style='color:white;'>There are no bills currently in the system matching your selected filters.</h2>";
                }
            }
        } else if (isset($_GET['subject_search']) && isset($_GET['bill_session']) && isset($_COOKIE['email']) && isset($_GET['bill_number'])) {
            $subject_search = $_GET['subject_search'];
            $bill_session = $_GET['bill_session'];
            $bill_number2 = $_GET['bill_number'];
            $subject_search = str_replace('_', ' ', $subject_search);
            $query = "SELECT * FROM law_table2 WHERE bill_summary is not NULL AND session='$bill_session' AND subject='$subject_search' AND bill_number='$bill_number2'";

            $session_link = "";
            $session_link = isset($_GET['session_link']) ? $_GET['session_link'] : '';
            if (!empty($session_link)) {
                $session_link2 = pg_escape_string($conn, $session_link);
                $session_link = "&session_filter=$session_link2";
            }

            $search_link = "";
            $search_link = isset($_GET['search_link']) ? $_GET['search_link'] : '';
            if (!empty($session_link)) {
                $search_link2 = pg_escape_string($conn, $search_link);
                $search_link = "&search-terms=$search_link2";
            }

            $result = pg_query($conn, $query);
            if ($result) {
                if (pg_num_rows($result) > 0) {
                    echo "<br><h2 class='text-center' style='color:white;'>Ask your questions about Bill Number: $bill_number2</h2>";
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
                        echo '<p><b>Bill Number: ' . $bill_number . ' | Session: ' . $bill_session . '</b>';
                        echo '<br><br>Synopsis: ' . $bill_synopsis . '</p>';
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
                        echo "<br><center><h4 class='text-dark'><a style='background-color: white;
                                color: black;
                                border: 2px solid blue;
                                padding: 10px 20px;
                                text-align: center;
                                text-decoration: none;
                                display: inline-block;' href='index.php?subject_search=$subject_search" . $session_link . $search_link . "'>Return to list of search results.</a></h4></center>";
                        $i++;
                    }
                    echo ("<br></div>");
                } else {
                    echo "<br><h2 class='text-center' style='color:white;'>There are no bills currently in the system matching your selected filters.</h2>";
                }
            }
        } else {
            if (isset($_GET['subject_search'])) {
                echo "<br><h2 class='text-center' style='color:white;'>Please select a legislative session (year) to search for.</h2>";
            } else {
                echo "<h2 class='text-center' style='color:white; margin:50px;'>Please select a legislative subject to search for.</h2>";
            }
        }
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