<?php


include('includes/Functions.php');


include ('includes/notification.php');


$SearchTerm = '';

if (isset($_POST['submitin'])) {
	
		$IncomeIds = $_POST['incomeid'];	
		//Get Account Id
		$GetAccountId = "SELECT AccountId FROM assets WHERE UserId = $UserId and AssetsId = $IncomeIds";
		$AccountId = mysqli_query($mysqli,$GetAccountId);
		$ColId = mysqli_fetch_array($AccountId);
		$AccId = $ColId['AccountId'];

		$Delete = "DELETE FROM assets WHERE AssetsId = $IncomeIds";
		$DeleteI = mysqli_query($mysqli,$Delete); 
		

		$TotalIncome = "UPDATE totals SET totals.Totals = (SELECT SUM(Amount) FROM assets where assets.UserId = $UserId AND assets.AccountId = totals.AccountId) \n"
    . "	WHERE totals.UserId = $UserId AND totals.AccountId = $AccId";
		$UpdateTotalIncome = mysqli_query($mysqli,$TotalIncome);
		if(!$UpdateTotalIncome){
			$Gagal="QUERY ERROR";
				 $msgBox = alertBox($Gagal);
			}

		$msgBox = alertBox($DeleteIncome);
	}
	

$GetIncomeHistory = "SELECT * from assets left join category on assets.CategoryId = category.CategoryId left join account on assets.AccountId = account.AccountId where assets.UserId = $UserId ORDER BY assets.Date DESC";
$IncomeHistory = mysqli_query($mysqli,$GetIncomeHistory); 



$GetAllIncomeOverall    = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId" ;
$GetAIncomeOverall      = mysqli_query($mysqli, $GetAllIncomeOverall);
$IncomeColOverall       = mysqli_fetch_assoc($GetAIncomeOverall);
$IncomeOverall          = $IncomeColOverall['Amount'];
    

$GetAllIncomeDate    = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId AND MONTH(Date) = MONTH (CURRENT_DATE())";
$GetAIncomeDate      = mysqli_query($mysqli, $GetAllIncomeDate);
$IncomeColDate       = mysqli_fetch_assoc($GetAIncomeDate);
$IncomeThisMonth     = $IncomeColDate['Amount'];

$GetAllIncomeDateToday       = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId AND Date = CURRENT_DATE()";
$GetAIncomeDateToday         = mysqli_query($mysqli, $GetAllIncomeDateToday);
$IncomeColDateToday          = mysqli_fetch_assoc($GetAIncomeDateToday);
$IncomeToday                 = $IncomeColDateToday['Amount'];


if (isset($_POST['searchbtn'])) {
	$SearchTerm = $_POST['search'];
	$GetIncomeHistory = "SELECT * from assets left join category on assets.CategoryId = category.CategoryId left join account on assets.AccountId = account.AccountId where 
					(assets.Title like '%$SearchTerm%' 
					OR account.AccountName like '%$SearchTerm%'
					OR assets.Description like '%$SearchTerm%' 
					OR category.CategoryName like '%$SearchTerm%')
					AND assets.UserId = $UserId ORDER BY assets.Date DESC";
$IncomeHistory = mysqli_query($mysqli,$GetIncomeHistory); 
	
}


	include ('includes/global.php');
	
	
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $IncomeSummary ;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php if ($msgBox) { echo $msgBox; } ?>
           
            <div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-success ">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $OverallReport; ?>
                        </div>
                        <div class="panel-body">
                            <p class="btn btn-primary"><?php echo $TotalIncomeToday; ?> <?php echo $ColUser['Currency'].' '.number_format($IncomeOverall);?></p><br/><br/>
                            <p class="btn btn-warning"><?php echo $TotalIncomeThisMonth; ?> <?php echo $ColUser['Currency'].' '.number_format($IncomeThisMonth);?></p><br/><br/>
                            <p class="btn btn-info"><?php echo $TotalIncomeReport; ?> <?php echo $ColUser['Currency'].' '.number_format($IncomeToday);?></p><br/><br/>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           <i class="glyphicon glyphicon-stats"></i> <?php echo $HistoryofAssets ;?>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="pull-right">
								<form action="" method="post">
							<div class="form-group input-group col-lg-5	pull-right">
                                          
                                 </div>
                                 </form> 
                                 
                            </div>     
                            <div class="">
                                <table class="table table-bordered table-hover table-striped" id="assetsdata">
                                    <thead>
        			                <tr>
        			                    <th class="text-left"><?php echo $Title ;?></th>
        			                    <th class="text-left"><?php echo $Date ;?></th>
        			                    <th class="text-left"><?php echo $Category ;?></th>
        			                    <th class="text-left"><?php echo $Account ;?></th>
        			                    <th class="text-left"><?php echo $Description ;?></th>
        			                    <th class="text-left"><?php echo $Amount ;?></th>        			                   
        			                </tr>
			                     </thead>

	                	<tbody>
							 <?php while($col = mysqli_fetch_assoc($IncomeHistory)){ ?>
							<tr>
							<td><?php echo $col['Title'];?></td>
							<td><?php echo date("M d Y",strtotime($col['Date']));?></td>
							<td><?php echo $col['CategoryName'];?></td>
							<td><?php echo $col['AccountName'];?></td>
							<td><?php echo $col['Description'];?></td>
							<td><?php echo $ColUser['Currency'].' '.number_format($col['Amount']);?></td>
							
							</tr>
	                	</tbody>
	                	

								
	                		 <?php } ?>   
						
		                <tfoot>
			                <tr>
			                    <th class="text-left"><?php echo $Title ;?></th>
			                    <th class="text-left"><?php echo $Date ;?></th>
			                    <th class="text-left"><?php echo $Category ;?></th>
			                    <th class="text-left"><?php echo $Account ;?></th>
			                    <th class="text-left"><?php echo $Description ;?></th>
			                    <th class="text-left"><?php echo $Amount ;?></th>      
			                </tr>
		                </tfoot>
	           			</table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                </div>
             
              
            </div>
           
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                </div>
            </div>
        </div>

   

