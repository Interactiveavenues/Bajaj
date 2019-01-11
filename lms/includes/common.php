<?php

class Iacommonclass {

    public function allowcharsnum() {
        
    }

    public function adminname() {
        global $db;
        $db->where("id", $_SESSION['adminid']);
        $adminname = $db->getOne("lpuser", "name");
        return $adminname['name'];
    }

    public function loggedinusermail() {
        global $db;
        $db->where("id", $_SESSION['userid']);
        $adminname = $db->getOne("lpuser", "email");
        return $adminname['email'];
    }

    public function roleaccess($currentrole, $allowrole = array(), $errorreredirect = false) {
        if (in_array($currentrole, $allowrole)) {
            return true;
        } else {
            if ($errorreredirect != false) {
                header('Location:' . ERRORPAGE);
                exit();
            } else {
                return false;
            }
        }
    }

    public function curlCall($qs, $wsUrl) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $wsUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $o = curl_exec($c);
        return $o;
    }

    public function strongpassword($string) {
        if (preg_match_all('/[a-z]/', $string) && preg_match_all('/[A-Z]/', $string) && preg_match_all('/[0-9]/', $string) && preg_match_all('/[!@#$%^&*()\-_=+{};:,<.>]/', $string)) {
            return true;
        } else {
            return false;
        }
    }

    public function generatepdf($html, $filename, $orientation = 'P') {
        $pdf = new TCPDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Bajaj Auto Limited');
        $pdf->SetTitle('Bajaj Online Vehicle Booking Challan');
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        if ($orientation == 'P') {
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        } else {
            $pdf->SetMargins(8, '5', 8);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            $pdf->SetAutoPageBreak(TRUE, 0);
        }

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $html = $html;


        $pdf->writeHTML($html, true, true, true, false, '');
        $pdf->lastPage();
        $pdf->Output(DIR_PATH . 'pdf/' . $filename, 'F');
    }

    public function showorder($path = array('detail' => 'ordersummary/', 'pagination' => 'user/orders?'), $filters = array()) {
        global $db;

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        if ($page <= 0)
            $page = 1;
        $db->pageLimit = $per_page = 10;
        $startpoint = ($page * $per_page) - $per_page;

        $db->orderBy("logid", "desc");

        // filter



        $orderlist = $db->arraybuilder()->paginate("downloadlog", $page, "*,(SELECT name FROM `lpuser` WHERE `id`=downloadlog.userid) as username,(SELECT emailid FROM `lpuser` WHERE `id`=downloadlog.userid) as useremail");

        $totalcount = $db->totalCount;

        if ($totalcount > 0) {
            $str = '<table class="table">
				<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Details</th><th>Time</th>
				</tr>
				</thead>
			<tbody>';
            foreach ($orderlist as $corder) {
                $str .= '<tr>				
						<td>' . $corder['username'] . '</td>
						<td>' . $corder['useremail'] . '</td>
						<td>' . implode("<br>", json_decode($corder['filterdata'], true)) . '</td><td>' . $corder['timestamp'] . '</td>
						</tr>';
            }
            $str .= '</table>';


            $str .= $this->pagination($totalcount, $per_page, $page, $url = MYWEBSITE . $path['pagination']);

            return $str;
        } else {
            return false;
        }
    }

    public function validateadmin() {
        if (!isset($_SESSION['adminid'])) {
            header('Location:' . MYWEBSITE . 'admin.php');
            exit();
        } else {
            global $db;
            $db->where("id", $_SESSION['adminid']);
            $db->where("status", 'active');
            $userdata = $db->getOne("lpuser", "id,emailid as username");
            if ($userdata['id']) {
                return $userdata['username'];
            } else {
                header('Location:' . MYWEBSITE);
                exit();
            }
        }
    }

    public function writelog($fpath, $logstring, $logsub = "Log", $encrypted = false) {
        if ($encrypted) {
            $logstring = $this->myCrypt($logstring, ENCKEY);
        }
        $logstring = "\r\n\r\n /*************** $logsub " . date('Y-m-d:h:i:s') . "********/\r\n" . $logstring;
        error_log($logstring, 3, DIR_PATH . 'logs/' . date('Ymd') . '_' . $fpath);
    }

    public function generate_password($length = 8, $varcharonly = 0, $ucase = 0) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        if ($varcharonly == 1) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }

        if ($ucase == '1') {
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }

        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    public function sendmail($to, $subject, $message, $from = ORDERMAIL, $attachment = "", $bcc = MAILCC, $host = SMTP_HOST, $uname = SMTP_USER, $password = SMTP_PASS, $port = SMTP_PORT, $mailname = SMTP_MAIL_NAME) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = $host;
        $mail->Port = $port;
        $mail->SMTPAuth = true;
        $mail->Username = $uname;
        $mail->Password = $password;
        $mail->setFrom($from, $mailname);
        if ($bcc) {
            $mail->addBCC($bcc);
        }
        $mail->addAddress($to);
        $mail->Subject = $subject;

        $message = str_replace('</body></html>', MAIL_FOOTER . '</body></html>', $message);
        $mail->msgHTML($message);
        if ($attachment) {
            $mail->addAttachment($attachment);
        }


        if (!$mail->send()) {
            $this->writelog('email.log', $mail->ErrorInfo, 'Mailer Error');
            return false;
        } else {
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
            return true;
        }
    }

    public function generatedropdownele($tablename, $key, $val, $selected = "", $cond = "") {
        $allstate = MysqliDb::getInstance()->get($tablename, $numRows = null, $columns = '*', $cond);
        $dropdownlist = "<option value=''> --Select-- </option>";
        foreach ($allstate as $cvalue) {
            $issel = "";
            if ($selected == $cvalue["$key"]) {
                $issel = "selected";
            }
            $dropdownlist .= '<option value="' . $cvalue[$key] . '" ' . $issel . ' >' . $cvalue[$val] . '</option>';
        }
        return $dropdownlist;
    }

    function myCrypt($plaintext, $key) {
        $key = pack('H*', bin2hex($key));
        //$key = pack('H*', $hexkey);
        //$key = bin2hex($key);
        # create a random IV to use with CBC encoding
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
        $ciphertext = $iv . $ciphertext;

        $ciphertext_base64 = base64_encode($ciphertext);
        return $ciphertext_base64;
    }

    function myDecrypt($ciphertext_base64, $key, $iv_size = "") {
        $key = pack('H*', bin2hex($key));
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $ciphertext_dec = base64_decode($ciphertext_base64);

        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        $ciphertext_dec = substr($ciphertext_dec, $iv_size);
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
        return $plaintext_dec;
    }

    function pagination($total, $per_page = 10, $page = 1, $url = '?') {

        $adjacents = "2";

        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $lastlabel = "Last &rsaquo;&rsaquo;";

        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $per_page;

        $prev = $page - 1;
        $next = $page + 1;

        $lastpage = ceil($total / $per_page);

        $lpm1 = $lastpage - 1; // //last page minus 1

        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            //$pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";

            if ($page > 1)
                $pagination .= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";

            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {

                if ($page < 1 + ($adjacents * 2)) {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='dot'>...</li>";
                    $pagination .= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                    $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li class='dot'>...</li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='dot'>..</li>";
                    $pagination .= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
                } else {

                    $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li class='dot'>..</li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination .= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination .= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }

            $pagination .= "</ul>";
        }

        return $pagination;
    }

    public function showuserroles($path = array('detail' => '?p=main_roleadd&cid=', 'pagination' => '', 'delete' => ''), $filters = array()) {
        global $db;

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        if ($page <= 0)
            $page = 1;
        $db->pageLimit = $per_page = 10;
        $startpoint = ($page * $per_page) - $per_page;

        $db->orderBy("id", "desc");

        // filter
        if (!empty($filters['email'])) {
            $db->where('emailid', '%' . $filters['email'] . '%', 'like');
        }


        $db->where('id', $_SESSION['adminid'], '!=');


        $orderlist = $db->arraybuilder()->paginate("lpuser", $page, "id,emailid,role");

        $totalcount = $db->totalCount;
        
        if ($totalcount > 0) {
            $str = '<table class="table">
				<thead>
				<tr>
					<th>Email</th>
					<th>Role</th>
					<th>View Details</th>
				</tr>
				</thead>
			<tbody>';
            foreach ($orderlist as $corder) {
                $str .= '<tr>				
						<td>' . $corder['emailid'] . '</td>
						<td>' . $corder['role'] . '</td>
						<td><a href="' . MYWEBSITE . $path['detail'] . $corder['id'] . '">View / Edit</a> <!-- | <a href="' . MYWEBSITE . $path['delete'] . $corder['id'] . '" class="confirmit">Delete</a>--></td>
						</tr>';
            }
            $str .= '</table>';


            $str .= "<div align='center' style='margin-top:50px;'>" . $this->pagination($totalcount, $per_page, $page, $url = MYWEBSITE . $path['pagination']) . "</div>";

            return $str;
        } else {
            return false;
        }
    }

    function showcombineinfo($data, $corder) {
        $customerinfo = '';
        $dataArr = array("addeddate", "modifydate", "permitvalidity", "validity");
        foreach ($data as $custkey => $custval) {
            if (in_array($custval, $dataArr)) {
                $customerinfo .= '<strong>' . $custkey . '</strong> : ' . date("d, M Y", strtotime($corder[$custval])) . "<br/>";
            } else {
                $customerinfo .= '<strong>' . $custkey . '</strong> : ' . $corder[$custval] . "<br/>";
            }
        }
        return $customerinfo;
    }

    function getDriverInfo($id) {
        global $db;

        $db->where('parentid', $id);
        $result = $db->get("leads");
        $driver = 'No Driver';
        if (count($result) > 0) {
            $driver = '';
            foreach ($result as $data) {
                $driver .= "<a href='" . MYWEBSITE . "?p=main_leads&did=" . $data["id"] . "' target='_blank'>" . $data["name"] . "</a><br/>";
            }
        }

        return $driver;
    }

    function getOwnerInfo($id) {
        global $db;

        $db->where('id', $id);
        $result = $db->get("leads");
        $driver = 'No Owner';
        if (count($result) > 0) {
            $driver = '';
            foreach ($result as $data) {
                $driver .= "<a href='" . MYWEBSITE . "?p=main_leads&uniqueid=" . $data["uniqueid"] . "'>" . $data["name"] . "</a><br/>";
            }
        }

        return $driver;
    }

    public function showleads($path = array('detail' => '?p=main_leadadd&cid=', 'pagination' => '', 'delete' => ''), $filters = array()) {
        global $db;

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        if ($page <= 0)
            $page = 1;
        $db->pageLimit = $per_page = 10;
        $startpoint = ($page * $per_page) - $per_page;

        $db->orderBy("id", "desc");



       
        $extrafield = '';
        $_SESSION['search'] = 0;
        if (!empty($filters['cname'])) {
            $db->where('name', '%' . $filters['cname'] . '%', "like");
            $_SESSION['search'] = 1;
        }
        if (!empty($filters['email'])) {
            $db->where('email', $filters['email']);
            $_SESSION['search'] = 1;
        }

        if (!empty($filters['mobile'])) {
            $db->where('mobile', $filters['mobile']);
            $_SESSION['search'] = 1;
        }
        if (!empty($filters['s'])) {
            $db->where('section', $filters['s']);
            $_SESSION['search'] = 1;
        }
        if (!empty($filters['source'])) {
            $db->where('source', $filters['source']);
            $_SESSION['search'] = 1;
        }
        if (!empty($filters['sdate']) && !empty($filters['edate'])) {
            $db->where("(date_format(created_date,'%Y-%m-%d') between '" . $filters['sdate'] . "' and '" . $filters['edate'] . "')");
        } else {
            if (!empty($filters['sdate'])) {
                $db->where("date_format(created_date,'%Y-%m-%d') = '" . $filters['sdate'] . "'");
                $_SESSION['search'] = 1;
            }
            if (!empty($filters['edate'])) {
                $db->where("date_format(created_date,'%Y-%m-%d') = '" . $filters['edate'] . "'");
                $_SESSION['search'] = 1;
            }
        }



        $orderlist = $db->arraybuilder()->paginate("leads", $page);
        $_SESSION['export_query'] = str_replace("SQL_CALC_FOUND_ROWS","",$db->getLastQuery()); 
        
        $totalcount = $db->totalCount;

        if ($totalcount > 0) {

            $str = '
                           <div class="pull-right"><strong>Total Count: ' . $totalcount . ' <br/><br/></strong></div>   
                        <table class="table table-bordered">
				<thead class="thead-dark">
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Mobile No</th>
					<th>State</th>
					<th>City</th>
					<th>Source</th>
					<th>User Journey</th>
					<th>Created Date</th>
					<th>Created Time</th>
					
				</tr>
				</thead>
			<tbody>';


            foreach ($orderlist as $corder) {

                $str .= '<tr>				
						<td>' . (($corder['name'] != '') ? $corder['name'] : ' -- ') . '</td>
						<td>' . (($corder['email'] != '') ? $corder['email'] : ' -- ') . '</td>
						<td>' . (($corder['mobile'] != '') ? $corder['mobile'] : ' -- ') . '</td>
						<td>' . (($corder['state'] != '') ? $corder['state'] : ' -- ') . '</td>
						<td>' . (($corder['city'] != '') ? $corder['city'] : ' -- ') . '</td>
						<td>' . (($corder['source'] != '') ? $corder['source'] : ' -- ') . '</td>
						<td>' . (($corder['user_click'] != '') ? $corder['user_click'] : ' -- ') . '</td>
						<td>' . (($corder['created_date'] != '') ? date("F j, Y", strtotime($corder['created_date'])) : ' -- ') . '</td>
						<td>' . (($corder['created_date'] != '') ? date("g:i a", strtotime($corder['created_date'])) : ' -- ') . '</td>
						
                                        </tr>';
            }
            $str .= '</table>';


            $str .= "<div align='center' style='margin-top:50px;'>" . $this->pagination($totalcount, $per_page, $page, $url = MYWEBSITE . $path['pagination']) . "</div>";

            return $str;
        } else {
            return false;
        }
    }

    public function showenquiries($path = array('detail' => '?p=main_leadadd&cid=', 'pagination' => '', 'delete' => ''), $filters = array()) {
        global $db;

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        if ($page <= 0)
            $page = 1;
        $db->pageLimit = $per_page = 10;
        $startpoint = ($page * $per_page) - $per_page;

        $db->orderBy("id", "desc");

        // filter
        $driverFlag = 0;



        $extrafield = '';

        if (!empty($filters['cname'])) {
            $db->where('name', '%' . $filters['cname'] . '%', "like");
        }
        if (!empty($filters['email'])) {
            $db->where('email', $filters['email']);
        }

        if (!empty($filters['mobile'])) {
            $db->where('phone', $filters['mobile']);
        }

        if (!empty($filters['sdate']) && !empty($filters['edate'])) {
            $db->where("(date_format(addeddate,'%Y-%m-%d') between '" . $filters['sdate'] . "' and '" . $filters['edate'] . "')");
        } else {
            if (!empty($filters['sdate'])) {
                $db->where("date_format(addeddate,'%Y-%m-%d') = '" . $filters['sdate'] . "'");
            }
            if (!empty($filters['edate'])) {
                $db->where("date_format(addeddate,'%Y-%m-%d') = '" . $filters['edate'] . "'");
            }
        }


        $colmns = array("*");
        $orderlist = $db->arraybuilder()->paginate("enquiry", $page, $colmns);
        //echo $db->getLastQuery(); exit;
        $totalcount = $db->totalCount;

        if ($totalcount > 0) {
            $str = '<table class="table">
				<thead>
				<tr>
					<th>Name</th>
					<th>Mobile</th>
					<th>Email</th>
					<th>Address</th>
					<th>RTO ID</th>
					<th>IP Address</th>
					<th>Created On</th>
					
				</tr>
				</thead>
			<tbody>';

            foreach ($orderlist as $corder) {

                $str .= '<tr>				
                                            <td>' . $corder["name"] . '</td>
                                            <td>' . $corder["phone"] . '</td>
                                            <td>' . $corder["email"] . '</td>
                                            <td>' . $corder["address"] . '</td>
                                            <td>' . $corder["rtoid"] . '</td>
                                            <td>' . $corder["ipaddress"] . '</td>
                                            <td>' . date("d M, Y", strtotime($corder["createdon"])) . '</td>
                                            
                                    </tr>';
            }
            $str .= '</table>';


            $str .= "<div align='center' style='margin-top:50px;'>" . $this->pagination($totalcount, $per_page, $page, $url = MYWEBSITE . $path['pagination']) . "</div>";

            return $str;
        } else {
            return false;
        }
    }

    function getUniqueId($series) {
        global $db;
        $db->where('series', $series);
        $result = $db->get("series");

        if (count($result) > 0) {
            $cnt = $result[0]["total"];
            $cnt = $cnt + 1;
            $data = array('total' => $cnt);
            $db->where('series', $series);
            $db->update("series", $data, 1);
        } else {
            $cnt = 1;
            $data = array('total' => '1', 'series' => $series);
            $db->insert("series", $data);
        }

        return $series . str_pad($cnt, 10, "0", STR_PAD_LEFT);
        ;
    }

}
