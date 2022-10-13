<?php session_start();

// Finished 
// Need to comment on the Get Function 


function ActiveClass($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}
		
		//check already login
		if (!isset($_SESSION['UserId'])) {
			header ('Location: login.php');
			exit;
		}

		// Logout
		if (isset($_GET['action'])) {
			$action = $_GET['action'];
			if ($action == 'logout') {
				session_destroy();
				header('Location: login.php');
			}
		}

if (isset($_GET['page']) && $_GET['page'] == 'Transaction') {
            $page = 'Transaction';
        } else if (isset($_GET['page']) && $_GET['page'] == 'AssetReport') {
            $page = "AssetReport";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageBudget') {
            $page = "ManageBudget";     
        } else if (isset($_GET['page']) && $_GET['page'] == 'ExpenseReport') {
            $page = "ExpenseReport";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageExpense') {
            $page = "ManageExpense";
        } else if (isset($_GET['page']) && $_GET['page'] == 'AllIncomeReports') {
            $page = "AllIncomeReports";
        } else if (isset($_GET['page']) && $_GET['page'] == 'AllExpenseReports') {
            $page = "AllExpenseReports";    
        } else {
            $page = 'dashboard';
        }

include('includes/global.php');

include('includes/header.php'); 

$msgBox	="";

if (file_exists('pages/'.$page.'.php')) {
            // Load the Page 
            include('pages/'.$page.'.php');
        } else {
            // Else Display an Error
          
            echo '
                    <div class="wrapper">
                        <h3>Err</h3>
                        <div class="alertMsg default">
                            <i class="icon-warning-sign"></i> The page "'.$page.'" could not be found.
                        </div>
                    </div>
                ';
        }

        include('includes/footer.php');
  

?>
