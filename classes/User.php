<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/27/2016
 * Time: 2:35 PM
 */

require_once "functions.php";

class User
{
    // Database connection info   (Separate class?, child class?)
    private $_cHost;
    private $_cUsername;
    private $_cPassword;
    private $_cDb;

    // User connection info
    private $_first;
    private $_last;
    private $_id;
    private $_email;
    private $_username;
    private $_demographic;

    // Not logged in info
    public $_authId;


    /*     Constructor       */
    //  Takes database connection info
    // User should make all database calls
    // Need the $parameters for security
    public function __construct($host, $username, $password, $db){
        $this->_cHost = $host;
        $this->_cUsername = $username;
        $this->_cPassword = $password;
        $this->_cDb = $db;
    }

    /*      Connects to Database     */
    //   With the given constructor values, it connects to the db
    private function connect(){
        $conn = new mysqli($this->_cHost, $this->_cUsername, $this->_cPassword, $this->_cDb);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error . " " . $this->_cPassword);

        return $conn;
    }


    /*      Login       */
    //  Logs user in
    // Creates authorization to enter site and query database
    public function login($username, $password){
        $conn = $this->connect();
        $stmt = $conn->prepare('SELECT
                  pass, id, first_name, last_name, email, demographic
                  FROM users
                  WHERE username = ?
                  LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($hash, $id, $first, $last, $email, $demo);
        $stmt->fetch();

        // Hashing the password with its hash as the salt returns the same hash
        $equals = hash_equals($hash, crypt($password, $hash));
        if ( $equals ) {
            $this->setId($id);
            $this->setEmail($email);
            $this->setUsername($username);
            $this->setFirst($first);
            $this->setLast($last);
            $this->setDemographic($demo);
        }
        $conn->close();
        return $equals;
    }

    /*      Register        */
    //  Registering new users
    // Creates user in users table
    // Logs them in as well with given information
    public function register($username, $password, $email, $phone, $first, $last){
        $conn = $this->connect();

        $hash = $this->createHashPass($password);

        $query = "INSERT INTO users (id, first_name, last_name, email, phone, username, pass, date_changed, date_entered) VALUES (NULL, ?, ?, ?, ?, ?, ?, now(), now())";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $first, $last, $email, $phone, $username, $hash);
        $stmt->execute();
        $id = $stmt->insert_id;

        if(isset($id)) {
            $this->setId($id);
            $this->setEmail($email);
            $this->setUsername($username);
            $this->setFirst($first);
            $this->setLast($last);
            $this->setDemographic(0);
        }

        $conn->close();
        return isset($id);

    }

    /*      Creates a random string     */
    //   Creates a string to be used as a salt for a password
    private function createKey(){
        // A higher "cost" is more secure but consumes more processing power
        $cost = 10;

        // Create a random salt
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        // Prefix information about the hash so PHP knows how to verify it later.
        // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
        $salt = sprintf("$2a$%02d$", $cost) . $salt;

        return $salt;
    }

    /*      Hashes Password     */
    //   Hashes password for database
    private function createHashPass($password){
        $salt = $this->createKey();

        // Hash the password with the salt
        return crypt($password, $salt);
    }

    /*      Creates Hash Key     */
    //   Creates a hash with a given auth string
    private function createHashAuth($auth){
        $salt = "Gka3rbrvIO";
        $hash = crypt($auth, $salt);

        return $hash;
    }

    /*      Username Taken?     */
    //   Checks username against usernames in table users
    // Case-insensitive
    public function checkUsername($username){
        $conn = $this->connect();
        $query_check = "select id from users where upper(username) = upper(?)";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $stmt_check->bind_result($prev);
        $stmt_check->fetch();

        $conn->close();
        return $prev;
    }

    /*      Get Available Surveys      */
    //  Sees what surveys are open for this user
    // Queries table surveys, not taken by this user id
    public function surveysOpen(){
        $conn = $this->connect();

        $surveys = "<div class=\"container\"><header><h2 class=\"alt\"><strong>Surveys</strong></h2></header><p>Open Surveys</p>";
        $query = "select id, title from surveys where id not in (SELECT survey from surveys_taken where user = ?) AND id <> 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->_id);
        $stmt->execute();
        $stmt->bind_result($id, $title);
        $i = 0;
        while($stmt->fetch()){
            $surveys .= "<button class=\"survey\" data-survey=\"$id\">$title</button>";
            $i++;
        }
        if($i == 0)
            $surveys .= "<p>It appears you've done all our available surveys. Check back later when we have more.</p>";

        $surveys .= "</div>";

        $conn->close();
        return $surveys;
    }

    /*      Creates Key for Reset Page     */
    //   Creates a key for a user and uploads to the password change request table
    public function createReset($id){
        $key = $this->createKey();
        $hash = $this->createHashAuth($key);

        $conn = $this->connect();

        $query_requests = "Insert into password_change_requests value (?, now(), ?, 0)";
        $stmt = $conn->prepare($query_requests);
        $stmt->bind_param("si", $hash, $id);
        $stmt->execute();

        $this->mailReset($id, $key);

        $conn->close();

        return true;
    }

    /*      Password Reset Email     */
    //   Sends email to users with password reset url
    private function mailReset($user, $key){
        $conn = $this->connect();
        $stmt = $conn->prepare('SELECT
                  email
                  FROM users
                  WHERE id = ?
                  LIMIT 1');
        $stmt->bind_param('i', $user);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        $url = "nuversity.com/reset.php?id=$key";

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: "Reset" <reset@nuversity.com>' . "\r\n";

        $subject = "Nuversity Password Reset";

        $message = "<html><div style=\"font-family: Verdana; font-size: 12px; font-color: black;\">
        Here's the link to reset your password reset<br><br>

        <a href='$url'>$url</a><br><br>

        If you didn't request this, please disregard this email<br><br>

        Nuversity<br><br>
        </div></html>";

        mail($email, $subject, $message, $headers);
    }

    /*      Reset Page Authorization        */
    //  Checks hash given by reset page key
    // Only gives authorization id (nothing about the user)
    // Checks if proper hash, already used, time provided < 24 hours ago
    public function checkReset($auth){
        $hash = $this->createHashAuth($auth);

        $conn = $this->connect();

        $query_requests = "Select time_request, used from password_change_requests where id = ?";
        $stmt = $conn->prepare($query_requests);
        $stmt->bind_param("s", $hash);
        $stmt->execute();
        $stmt->bind_result($time, $used);
        $stmt->fetch();
        $conn->close();

        // Return errors with key
        if(!isset($time))
            return false;
        if($used)
            return "This password reset has already been used";

        $dateTime = strtotime($time);   $dateDayAgo = strtotime("-24 hours");
        if($dateTime < $dateDayAgo)
            return "We're sorry but this password change request was made more than 24 hours ago";

        // Return that user has Auth Id for password reset
        $this->_authId = $auth;
        return true;
    }

    /*      Resets Password         */
    //  Uses Auth Id from checkReset()
    // Should only be called after checkReset
    public function resetPassword($password){
        if(!isset($this->_authId))
            return false;

        $hashAuth = $this->createHashAuth($this->_authId);

        $conn = $this->connect();

        $query_requests = "Select userId from password_change_requests where id = ?";
        $stmt = $conn->prepare($query_requests);
        $stmt->bind_param("s", $hashAuth);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();

        $hashPass = $this->createHashPass($password);
        $update_user = "Update users set pass = ? where id = ? ";
        $stmt = $conn->prepare($update_user);
        $stmt->bind_param("si", $hashPass, $id);
        $stmt->execute();
        $stmt->close();

        $update_auth = "Update password_change_requests set used = 1 where id = ?";
        $stmt = $conn->prepare($update_auth);
        $stmt->bind_param("s", $hashAuth);
        $stmt->execute();
        $stmt->close();

        $conn->close();
        return $hashAuth;
    }


    /*      Gets Survey         */
    //  Grabs survey description, referrals, questions, etc
    // Queries  survey table for info
    //          questions table for questions
    public function getSurvey($survey){
        $conn = $this->connect();

        // Queries
        $query_survey = "Select title, description, instructions, referrals, specifications from surveys where id = ?";
        $query_questions = "select questions.id, questions.question, questions.qType, answer_options.id, answer_options.answer from questions left join answer_options on questions.answers = answer_options.selection where survey = ? order by questions.id, answer_options.answer;";

        // Get Survey Information
        $stmt = $conn->prepare($query_survey);
        $stmt->bind_param("i", $survey);
        $stmt->execute();
        $stmt->bind_result($title, $description, $instructions, $referrals, $spec);
        $stmt->fetch();
        $stmt->close();

    //  ----- Survey Info ------
        // Survey Title
        $title = "<div class=\"container\"><header><h2 class=\"alt\"><strong>$title</strong></h2></header></div>";

        // Add Survey Description
        if(isset($description))
            $desc = "<div class=\"container\"><header><h2> Description </h2></header><p>$description</div></section>";

        // Add Survey Instructions
        if(isset($instructions))
            $instr = "<div class=\"container\"><header><h2>Instructions</h2></header><p>$instructions</p></div>";

        // Add Survey Referral
        if(isset($referrals))
            $ref = "<div class=\"container\"><header><h2>Referrals</h2></header><p>$referrals</p><textarea id='referralText' rows='5' cols='40'></textarea></div>";

    // ----- Survey ------

        // Questions html
        $questions = "";

        // Query Questions
        $stmt_q = $conn->prepare($query_questions);
        $stmt_q->bind_param("i", $survey);
        $stmt_q->execute();
        $stmt_q->bind_result($Qid, $question, $Qtype, $Aid, $answers);

        $prevId = 0;
        $otherId = null;

        // While each question  (complex af fix pls)
        while($stmt_q->fetch()){
            if($prevId != $Qid) {
                if(isset($otherId)){
                    $questions .= "</select></div>";
                }

                // Individual question html start
                $questions .= "<div class='question' data-id=\"$Qid\">$question<br>";

                // If is integer/selection input, if not text
                if($Qtype == 1){

                    // If is selection, if not integer
                    if(isset($Aid)){
                        $questions .= "<select name=\"$Qid\" required><option selected disabled hidden value=''></option><option value=\"$Aid\">$answers</option>";
                    }else{
                        $questions .= "<input type=\"number\" name=\"$Qid\" required /></div>";
                    }

                }else{
                    $questions .= "<textarea data-autoresize rows=\"2\" name=\"$Qid\" required /></div>";
                }

                // End this question
                $prevId = $Qid;   $otherId = $Aid;
            }else{
                $questions .= "<option value=\"$Aid\">$answers</option>";
            }
        }
        if(isset($otherId)){
            $questions .= "</select></div>";
        }

        // Place questions in survey
        $surv = "<div class=\"container\"><header><h2>Survey</h2><p>$spec</p></header><form id='surveyForm'>$questions<button type='submit'>Submit</button></form></div>";

        $conn->close();

        // Result data for js retrieval
        $results = [title => $title, description => $desc, referrals => $ref, instructions => $instr, survey => $surv];
        return json_encode($results);
    }



    /*        Set member Variables      */
    public function setId($id){$this->_id = $id;}
    public function setEmail($email){$this->_email = $email;}
    public function setUsername($username){$this->_username = $username;}
    public function setDemographic($demographic){$this->_demographic = $demographic;}
    public function setFirst($first){$this->_first = $first;}
    public function setLast($last){$this->_last = $last;}
    /*       End Set            */

    /*       Get Member Variables        */
    public function getEmail(){return $this->_email;}
    public function getDemographic(){return $this->_demographic;}
    public function getUsername(){return $this->_username;}
    public function getId(){return $this->_id;}
    public function getName(){return $this->getFirst()." ".$this->getLast();}
    public function getFirst(){return $this->_first;}
    public function getLast(){return $this->_last;}
    /*      End Get       */
}