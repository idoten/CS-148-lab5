<?php
include 'top.php';
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//     
print  PHP_EOL . '<!-- SECTION: 1 Initialize variables -->' . PHP_EOL;       
// These variables are used in both sections 2 and 3, otherwise we would
// declare them in the section we needed them
print  PHP_EOL . '<!-- SECTION: 1a. debugging setup -->' . PHP_EOL;
// We print out the post array so that we can see our form is working.
// Normally i wrap this in a debug statement but for now i want to always
// display it. when you first come to the form it is empty. when you submit the
// form it displays the contents of the post array.
//if ($debug){ 
    print '<p>Post Array:</p><pre>';
    print_r($_POST);
    print '</pre>';
//}
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1b form variables -->' . PHP_EOL;
//
// Initialize variables one for each form element
// in the order they appear on the form

$trailName = ""; // trail name text box
$totalDistance = "In miles"; // total distance text box
$hikingTimeHours = "hh"; // hiking time text box for hours
$hikingTimeMinutes = "mm"; // hiking time text box for minutes
$hikingTimeSeconds = "ss"; // hiking time text box for seconds
$verticalRise = "in feet"; // vertical rise text box
$rating = ""; // rating text box
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form   

$trailNameERROR = false; // trail name error
$totalDistanceERROR = false; // total distance error
$hikingTimeHoursERROR = false;
$hikingTimeMinutesERROR = false;
$hikingTimeSecondsERROR = false;
$verticalRiseERROR = false; // vertical rise error
$ratingERROR = false; // rating error
////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1d misc variables -->' . PHP_EOL;
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.

$errorMsg = array();             
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
print PHP_EOL . '<!-- SECTION: 2 Process for when the form is submitted -->' . PHP_EOL;
//
if (isset($_POST["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2a Security -->' . PHP_EOL;
    
    // the url for this form
    $thisURL = $domain . $phpSelf;
    
    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry you cannot access this page.</p>';
        $msg.= '<p>Security breach detected and reported.</p>';
        die($msg);
    }
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2b Sanitize (clean) data  -->' . PHP_EOL;
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.
    
    $trailName = htmlentities($_POST["txtTrailName"], ENT_QUOTES, "UTF-8");
    $totalDistance = htmlentities($_POST["txtTotalDistance"], ENT_QUOTES, "UTF-8");
    $hikingTimeHours = htmlentities($_POST["txtHikingTimeHours"], ENT_QUOTES, "UTF-8");
    $hikingTimeMinutes = htmlentities($_POST["txtHikingTimeMinutes"], ENT_QUOTES, "UTF-8");
    $hikingTimeSeconds = htmlentities($_POST["txtHikingTimeSeconds"], ENT_QUOTES, "UTF-8");
    $verticalRise = htmlentities($_POST["txtVerticalRise"], ENT_QUOTES, "UTF-8");
    $rating = htmlentities($_POST["txtRating"], ENT_QUOTES, "UTF-8");
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2c Validation -->' . PHP_EOL;
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.
    
    //$trailName = "trails"; // trail name text box
    //$totalDistance = "distance"; // total distance text box
    //$hikingTime = "time"; // hiking time text box
    //$verticalRise = "rise"; // vertical rise text box
    //$rating = "rating"; // rating text box
    
    if ($trailName != "") {
        if (!verifyAlphaNum($trailName)) {
            $errorMsg[] = "Your trail name appears to have extra characters that are not allowed.";
            $trailNameERROR = true;
        }
    }
    
    if ($totalDistance != "") {
        if (!verifyNumeric($totalDistance)) {
            $errorMsg[] = "Your distance appears to have extra characters that are not allowed.";
            $totalDistanceERROR = true;
        }else if ($totalDistance <= 0) {
            $errorMsg[] = "Your distance must be more than zero.";
            $totalDistanceERROR = true;
        }
    }
    
    if ($hikingTimeHours != "") {
        if (!verifyNumeric($hikingTimeHours)) {
            $errorMsg[] = "Your hiking hours appears to have extra characters that are not allowed.";
            $hikingTimeHoursERROR = true;
        }
    }
    
    if ($hikingTimeMinutes != "") {
        if (!verifyNumeric($hikingTimeMinutes)) {
            $errorMsg[] = "Your hiking minutes appears to have extra characters that are not allowed.";
            $hikingTimeMinutesERROR = true;
        }
    }
    
    if ($hikingTimeSeconds != "") {
        if (!verifyNumeric($hikingTimeSeconds)) {
            $errorMsg[] = "Your hiking seconds appears to have extra characters that are not allowed.";
            $hikingTimeSecondsERROR = true;
        }
    }
    
    if ($verticalRise != "") {
        if (!verifyNumeric($verticalRise)) {
            $errorMsg[] = "Your vertical rise appears to have extra characters that are not allowed.";
            $verticalRiseERROR = true;
        }
    }
    
    if ($rating != "") {
        if (!verifyAlphaNum($rating)) {
            $errorMsg[] = "Your rating appears to have extra characters that are not allowed.";
            $ratingERROR = true;
        }
    }
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2d Process Form - Passed Validation -->' . PHP_EOL;
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    if (!$errorMsg) {
        if ($debug)
                print '<p>Form is valid</p>';
             
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        print PHP_EOL . '<!-- SECTION: 2e Save Data -->' . PHP_EOL;
        //
        // This block saves the data to a CSV file.   
        
        // array used to hold form values that will be saved to a CSV file
        $dataRecord = array();       
        
        // assign values to the dataRecord array 
        $hikingTime = $hikingTimeHours . ':' . $hikingTimeMinutes . ':' . $hikingTimeSeconds;
        $dataRecord[] = $trailName;
        $dataRecord[] = $totalDistance;
        $dataRecord[] = $hikingTime;
        $dataRecord[] = $verticalRise;
        $dataRecord[] = $rating;
        
         try {
            $thisDatabaseWriter->db->beginTransaction();

            $query = 'INSERT INTO tblTrails SET ';

            $query .= 'fldTrailName = ?, ';
            $query .= 'fldTotalDistance = ?, ';
            $query .= 'fldHikingTime = ?, ';
            $query .= 'fldVerticalRise = ?, ';
            $query .= 'fldRating = ? ';

            if (DEBUG) {
                $thisDatabaseWriter->TestSecurityQuery($query, 0);
                print_r($dataRecord);
            }

            if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                $query = $thisDatabaseWriter->sanitizeQuery($query);
                
                $results = $thisDatabaseWriter->insert($query, $dataRecord);
                
                $primaryKey = $thisDatabaseWriter->lastInsert();

                if (DEBUG) {
                    print "<p>pmk= " . $primaryKey;
                }
            }

            // all sql statements are done so lets commit to our changes

            $dataEntered = $thisDatabaseWriter->db->commit();
            
            if (DEBUG)
                print "<p>transaction complete ";
        } catch (PDOException $e) {
            $thisDatabaseWriter->db->rollback();
            if (DEBUG)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accepting your data please contact us directly.";
        }    
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        print PHP_EOL . '<!-- SECTION: 2f Create message -->' . PHP_EOL;
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).
        $message = '<h2>Your  information.</h2>';       
        foreach ($_POST as $htmlName => $value) {
            
            $message .= '<p>';
            // breaks up the form names into words. for example
            // txtFirstName becomes First Name       
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . ' ';
            }
    
            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        }
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        //print PHP_EOL . '<!-- SECTION: 2g Mail to user -->' . PHP_EOL;
        //
        // Process for mailing a message which contains the forms data
        //// the message was built in section 2f.
        //$to = $email; // the person who filled out the form     
        //$cc = '';       
        //$bcc = '';
        //$from = 'WRONG site <customer.service@your-site.com>';
        //// subject of mail should make sense to your form
        //$subject = 'Groovy: ';
        //$mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // end form is valid     
}   // ends if form was submitted.
//#############################################################################
//
print PHP_EOL . '<!-- SECTION 3 Display Form -->' . PHP_EOL;
//
?>       
<main>     
    <article>
<?php
    //####################################
    //
    print PHP_EOL . '<!-- SECTION 3a  -->' . PHP_EOL;
    // 
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print '<h2>Thank you for providing your information.</h2>';
    
        //print '<p>For your records a copy of this data has ';
        //if (!$mailed) {    
        //    print "not ";         
        //}
    
        //print 'been sent:</p>';
        //print '<p>To: ' . $email . '</p>';
    
        print $message;
    } else {       
     print '<h2>Add Trails</h2>';
     print '<p class="form-heading">Please enter a new hiking trail.</p>';
     
        //####################################
        //
        print PHP_EOL . '<!-- SECTION 3b Error Messages -->' . PHP_EOL;
        //
        // display any error messages before we print out the form
   
       if ($errorMsg) {    
           print '<div id="errors">' . PHP_EOL;
           print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
           print '<ol>' . PHP_EOL;
           foreach ($errorMsg as $err) {
               print '<li>' . $err . '</li>' . PHP_EOL;       
           }
            print '</ol>' . PHP_EOL;
            print '</div>' . PHP_EOL;
       }
        //####################################
        //
        print PHP_EOL . '<!-- SECTION 3c html Form -->' . PHP_EOL;
        //
        /* Display the HTML form. note that the action is to this same page. $phpSelf
            is defined in top.php
            NOTE the line:
            value="<?php print $email; ?>
            this makes the form sticky by displaying either the initial default value (line ??)
            or the value they typed in (line ??)
            NOTE this line:
            <?php if($emailERROR) print 'class="mistake"'; ?>
            this prints out a css class so that we can highlight the background etc. to
            make it stand out that a mistake happened here.
       */
?>    



<form action = "<?php print $phpSelf; ?>"
          id = "frmHiker"
          method = "post">

        <!--trail name-->
        <fieldset class="textarea">
            <p>
                <label  class="required"for="txtTrailName">Trail Name</label>
                <textarea <?php if ($trailNameERROR) print 'class="mistake"'; ?>
                    id="txtTrailName" 
                    name="txtTrailName" 
                    onfocus="this.select()" 
                    tabindex="200"><?php print $trailName; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                     the text area directly -->
            </p>
        </fieldset> <!-- ends text -->
        
        <!--total distance-->
        <fieldset class="textarea">
            <p>
                <label  class="required"for="txtTotalDistance">Total Distance</label>
                <textarea <?php if ($totalDistanceERROR) print 'class="mistake"'; ?>
                    id="txtTotalDistance" 
                    name="txtTotalDistance" 
                    onfocus="this.select()" 
                    tabindex="200"><?php print $totalDistance; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                     the text area directly -->
            </p>
        </fieldset> <!-- ends text -->
        
        <!--hiking time-->
        <fieldset class="textarea">
            <p>
                <label  class="required"for="txtHikingTimeHours">Hiking Time</label>
                <textarea <?php if ($hikingTimeHoursERROR) print 'class="mistake"'; ?>
                    id="txtHikingTimeHours" 
                    name="txtHikingTimeHours" 
                    onfocus="this.select()" 
                    tabindex="200"><?php print $hikingTimeHours; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                     the text area directly -->
                    
                <label  class="required"for="txtHikingTimeMinutes">:</label>
                <textarea <?php if ($hikingTimeMinutesERROR) print 'class="mistake"'; ?>
                    id="txtHikingTimeMinutes" 
                    name="txtHikingTimeMinutes" 
                    onfocus="this.select()" 
                    tabindex="200"><?php print $hikingTimeMinutes; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                     the text area directly -->
                
                <label  class="required"for="txtHikingTimeSeconds">:</label>
                <textarea <?php if ($hikingTimeSecondsERROR) print 'class="mistake"'; ?>
                    id="txtHikingTimeSeconds" 
                    name="txtHikingTimeSeconds" 
                    onfocus="this.select()" 
                    tabindex="200"><?php print $hikingTimeSeconds; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                     the text area directly -->
        </fieldset> <!-- ends text -->
        
        <!--vertical rise-->
        <fieldset class="textarea">
            <p>
                <label  class="required"for="txtVerticalRise">Vertical Rise</label>
                <textarea <?php if ($verticalRiseERROR) print 'class="mistake"'; ?>
                    id="txtVerticalRise" 
                    name="txtVerticalRise" 
                    onfocus="this.select()" 
                    tabindex="200"><?php print $verticalRise; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                     the text area directly -->
            </p>
        </fieldset> <!-- ends text -->
        
        <!--rating-->
        <fieldset class="textarea">
            <p>
                <label  class="required"for="txtRating">Rating</label>
                <textarea <?php if ($ratingERROR) print 'class="mistake"'; ?>
                    id="txtRating" 
                    name="txtRating" 
                    onfocus="this.select()" 
                    tabindex="200"><?php print $rating; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                     the text area directly -->
            </p>
        </fieldset> <!-- ends text -->
            
        <fieldset class="buttons">
            <legend></legend>
            <input class = "button" id = "btnSubmit" name = "btnSubmit" tabindex = "900" type = "submit" value = "Submit" >
        </fieldset> <!-- ends buttons -->
</form>     
<?php
    } // ends body submit
?>
    </article>     
</main>     

<?php include 'footer.php'; ?>

</body>     
</html>