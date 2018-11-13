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
if ($debug){ 
    print '<p>Post Array:</p><pre>';
    print_r($_POST);
    print '</pre>';
}
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1b form variables -->' . PHP_EOL;
//
// Initialize variables one for each form element
// in the order they appear on the form
//$firstName = "";       
//$email = "your-email@uvm.edu";
$hikers = "hikers"; // hikers list box
$trails = "trails"; //trails check box
////$date = "mm/dd/yyyy";
$dateMonth = "mm"; //date text box
$dateDay = "dd";
$dateYear = "yyyy";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form
//$firstNameERROR = false;
//$emailERROR = false;     
$hikersERROR = false;
$trailsERROR = false;
//$dateERROR = false;
$dateMonthERROR = false;
$dateDayERROR = false;
$dateYearERROR =false;
////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1d misc variables -->' . PHP_EOL;
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();       
 
// have we mailed the information to the user, flag variable?
//$mailed = false;       
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
    //$firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");       
    
    //$email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);       
        
    $hikers = htmlentities($_POST["lstFavoriteHiker"], ENT_QUOTES, "UTF-8");
    $trails = htmlentities($_POST["radTrails"], ENT_QUOTES, "UTF-8");
    //$date = htmlentities($_POST["txtDate"], ENT_QUOTES, "UTF-8");
    $dateMonth = htmlentities($_POST["txtDateMonth"], ENT_QUOTES, "UTF-8");
    $dateDay = htmlentities($_POST["txtDateDay"], ENT_QUOTES, "UTF-8");
    $dateYear = htmlentities($_POST["txtDateYear"], ENT_QUOTES, "UTF-8");
    
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
    //if ($firstName == "") {
    //    $errorMsg[] = "Please enter your first name";
    //    $firstNameERROR = true;
    //} elseif (!verifyAlphaNum($firstName)) {
    //    $errorMsg[] = "Your first name appears to have extra character.";
    //    $firstNameERROR = true;
    //}
    
    //if ($email == "") {
    //    $errorMsg[] = 'Please enter your email address';
    //    $emailERROR = true;
    //} elseif (!verifyEmail($email)) {       
    //    $errorMsg[] = 'Your email address appears to be incorrect.';
    //    $emailERROR = true;    
    //}    
    
    //hikers error
    if ($hikers == "") {
        $errorMsg[] = "Please choose a hiker";
        $hikersERROR = true;
    }
    if ($hikers != "1" AND $hikers != "2" AND $hikers != "3" 
            AND $hikers != "4" AND $hikers != "5"){
        $errorMsg[] = "Please choose a proper hiker";
        $hikersERROR = true;
    }
    
    //trails
    if ($trails != "1" AND $trails != "2" AND $trails != "3"
            AND $trails != "4" AND $trails != "5"){
        $errorMsg[] = "Please choose a trail";
        $trailsERROR = true;
    }
    
    //!date!
    //if ($date != "") {
        //if (!verifyAlphaNum($date)) {
            //$errorMsg[] = "Your comments appear to have extra characters that are not allowed.";
            //$dateERROR = true;
        //}
    //}
    
    //!place holder date error!
    if (verifyNumeric($dateMonth)) {
        if ($dateMonth < 1 OR $dateMonth > 12) {
            $errorMsg[] = "Your month does not appear to be a valid month";
            $dateMonthERROR = true;
        }
    } else{
        $errorMsg[] = "Your month does not appear to be in month format";
        $dateMonthERROR = true;
    }
    if ($dateMonth == "") {
        $errorMsg[] = "Please enter a date month";
        $dateMonthERROR = true;
    }
        if ($dateMonth == "1"){
            $dateMonth == "01";
        }
        if ($dateMonth == "2"){
            $dateMonth == "02";
        } 
        if ($dateMonth == "3"){
            $dateMonth == "03";
        } 
        if ($dateMonth == "4"){
            $dateMonth == "04";
        } 
        if ($dateMonth == "5"){
            $dateMonth == "05";
        } 
        if ($dateMonth == "6"){
            $dateMonth == "06";
        } 
        if ($dateMonth == "7"){
            $dateMonth == "07";
        } 
        if ($dateMonth == "8"){
            $dateMonth == "08";
        } 
        if ($dateMonth == "9"){
            $dateMonth == "09";
        }
    
    if (verifyNumeric($dateDay)) {
        if ($dateDay < 1 OR $dateDay > 31) {
            $errorMsg[] = "Your day does not appear to be a valid day";
            $dateDayERROR = true;
        }
    } else{
        $errorMsg[] = "Your day does not appear to be in day format";
        $dateDayERROR = true;
    }
        if ($dateDay == "1"){
            $dateDay == "01";
        }
        if ($dateDay == "2"){
            $dateDay == "02";
        } 
        if ($dateDay == "3"){
            $dateDay == "03";
        } 
        if ($dateDay == "4"){
            $dateDay == "04";
        } 
        if ($dateDay == "5"){
            $dateDay == "05";
        } 
        if ($dateDay == "6"){
            $dateDay == "06";
        } 
        if ($dateDay == "7"){
            $dateDay == "07";
        } 
        if ($dateDay == "8"){
            $dateDay == "08";
        } 
        if ($dateDay == "9"){
            $dateDay == "09";
        }
        
    if (verifyNumeric($dateYear)) {
        if ($dateYear < 1950 OR $dateYear > 2050) {
            $errorMsg[] = "Your year does not appear to be a valid year";
            $dateYearERROR = true;
        }
    } else{
        $errorMsg[] = "Your year does not appear to be in year format";
        $dateYearERROR = true;
    }
    if ($dateMonth == "") {
        $errorMsg[] = "Please enter a date year ";
        $dateYearERROR = true;
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
        //$dataRecord[] = $firstName;
        //$dataRecord[] = $email; 
        
        $date = ($dateYear . "-" . $dateMonth . "-" . $dateDay);  //!TO COMMENT OUT ONCE FIXED!
        $dataRecord[] = $hikers;
        $dataRecord[] = $trails;
        $dataRecord[] = $date;
        
         try {
            $thisDatabaseWriter->db->beginTransaction();

            $query = 'INSERT INTO tblHikersTrails SET ';

            $query .= 'fnkHikersId = ?, ';
            $query .= 'fnkTrailsId = ?, ';
            $query .= 'fldDateHiked = ? ';

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
    
        // setup csv file
        //$myFolder = 'data/';
        //$myFileName = 'lab4';
        //$fileExt = '.csv';
        //$filename = $myFolder . $myFileName . $fileExt;
    
        //if ($debug) print PHP_EOL . '<p>filename is ' . $filename;
    
        // now we just open the file for append
        //$file = fopen($filename, 'a');
    
        // write the forms informations
        //fputcsv($file, $dataRecord);
    
        // close the file
        //fclose($file);       
    
     
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
     print '<h2>Please enter a new hiking venture </h2>';
     print '<p class="form-heading">Please enter a new hiking venure.</p>';
     
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

            <fieldset  class="listbox <?php if ($hikersERROR) print ' mistake'; ?>">
                <p>
                <legend>Favorite Hiker</legend>
                    <select id="FavoriteHiker" 
                        name="lstFavoriteHiker" 
                        tabindex="520" >
                        <option <?php if ($hikers == "1") print " selected "; ?>
                            value="1">Ian Doten</option>

                        <option <?php if ($hikers == "2") print " selected "; ?>
                            value="2">Emalee Sprague</option>

                        <option <?php if ($hikers == "3") print " selected "; ?>
                            value="3">Heidi Grace</option>
                    
                        <option <?php if ($hikers == "4") print " selected "; ?>
                            value="4">Conor Barrett</option>
                    
                        <option <?php if ($hikers == "5") print " selected "; ?>
                            value="5">Howie Woods</option>
                    </select>
                </p>
            </fieldset> <!-- ends list -->
            
            <!--<fieldset class="textarea">
                <p>
                   <label  class="required"for="txtDate">Date</label>
                    <textarea <?//php if ($dateERROR) print 'class="mistake"'; ?>
                        id="txtDate" 
                        name="txtDate" 
                        onfocus="this.select()" 
                        accesskey=""tabindex="200"><?//php print $date; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                        the text area directly -->
                <!--</p>
            </fieldset> <!-- ends date --> 
                
            <fieldset class="textarea">
                <p>
                   <label  class="required"for="txtDateMonth">Date</label>
                    <textarea <?php if ($dateMonthERROR) print 'class="mistake"'; ?>
                        id="txtDateMonth" 
                        name="txtDateMonth" 
                        onfocus="this.select()" 
                        accesskey=""tabindex="200"><?php print $dateMonth; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                        the text area directly -->

                   <label  class="required"for="txtDateDay">/</label>
                    <textarea <?php if ($dateMonthERROR) print 'class="mistake"'; ?>
                        id="txtDateDay" 
                        name="txtDateDay" 
                        onfocus="this.select()" 
                        accesskey=""tabindex="200"><?php print $dateDay; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                        the text area directly -->

                   <label  class="required"for="txtDateYear">/</label>
                    <textarea <?php if ($dateYearERROR) print 'class="mistake"'; ?>
                        id="txtDate" 
                        name="txtDateYear" 
                        onfocus="this.select()" 
                        accesskey=""tabindex="200"><?php print $dateYear; ?></textarea>
                    <!-- NOTE: no blank spaces inside the text area, be sure to close 
                        the text area directly -->
                </p>
            </fieldset> <!-- ends date --> 
            
            <fieldset class="radio <?php if ($trailsERROR) print ' mistake'; ?>">
                <legend>What trail was hiked?</legend>
                <p>
                    <label class="radio-field"><input type="radio" id="radTrail" name="radTrails" value="1" tabindex="574" 
            <?php if ($trails == "1") echo ' checked="checked" '; ?>>
                    Camel's Hump</label>
                </p>
                <p>
                    <label class="radio-field"><input type="radio" id="radTrail" name="radTrails" value="2" tabindex="574" 
            <?php if ($trails == "2") echo ' checked="checked" '; ?>>
                    Snake Mountain</label>
                </p>

                <p>
                    <label class="radio-field"><input type="radio" id="radTrail" name="radTrails" value="3" tabindex="574" 
            <?php if ($trails == "3") echo ' checked="checked" '; ?>>
                    Prospect Rock</label>
                </p>
                <p>
                    <label class="radio-field"><input type="radio" id="radTrail" name="radTrails" value="4" tabindex="574" 
            <?php if ($trails == "4") echo ' checked="checked" '; ?>>
                    Skylight Pond</label>
                </p>

                <p>
                    <label class="radio-field"><input type="radio" id="radTrail" name="radTrails" value="5" tabindex="574" 
            <?php if ($trails == "5") echo ' checked="checked" '; ?>>
                    Mount Pisgah</label>
                </p>
            </fieldset> <!-- ends radio -->
            
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