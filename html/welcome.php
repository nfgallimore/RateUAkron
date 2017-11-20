<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
    exit;
    }
    require_once '../includes/config.php';
    $sql = "SELECT Id, Title, Description, Instructor FROM Courses";
    $courses = [];
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
	        while($row = mysqli_fetch_array($result)){
		            $courses[] = [
			                    'Id' => $row['Id'],
					                    'Title' => $row['Title'],
							                    'Description' => $row['Description'],
									                    'Instructor' => $row['Instructor']
											                ];
													        }
														        mysqli_free_result($result);
															    } else{
															            echo "No records matching your query were found.";
																        }
																	} else{
																	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
																	    }

mysqli_close($link);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <title>Welcome</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

    <script>
        $(document).ready(function() {
	      $(".search").keyup(function () {
	              var searchTerm = $(".search").val();
		              var listItem = $('.results tbody').children('tr');
			              var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

      $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
                  return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
		          }
			        });

      $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
              $(this).attr('visible','false');
	            });

      $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
              $(this).attr('visible','true');
	            });

      var jobCount = $('.results tbody tr[visible="true"]').length;
              $('.counter').text(jobCount + ' item');

      if(jobCount == '0') {$('.no-result').show();}
              else {$('.no-result').hide();}
	                });
			    });
			        </script>

    <style type="text/css">
            body{ font: 14px sans-serif; text-align: center; padding:20px 20px; }

        .results tr[visible='false'],

        .no-result{
	          display:none;
		          }

        .results tr[visible='true']{
	          display:table-row;
		          }

        .counter{
	          padding:8px;
		            color:#ccc;
			            }
				        </style>
					</head>
					<body>
					    <div class="page-header">
					            <h1>Hi, <b><?php echo $_SESSION['username']; ?></b>.<br>Welcome to University of Akron course evaluations.</h1>
						            <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
							            <div class="form-group pull-right">
								                <input type="text" class="search form-control" placeholder="What you looking for?">
										        </div>
											        <span class="counter pull-right"></span>
												        <table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc" class="table text-align:left table-hover table-bordered results">
													            <thead>
														                    <tr>
																                        <th data-field="id" data-sortable="true" class="col-md-5 col-xs-5"> Course ID </th>
																			                    <th data-field="name" data-sortable="true" class="col-md-4 col-xs-4"> Name </th>
																					                        <th data-field="instructor" data-sortable="true" class="col-md-3 col-xs-3"> Instructor </th>
																								                    <th data-field="description" data-sortable="true" class="col-md-2 col-xs-2"> Description </th>
																										                    </tr>
																												                    <tr class="warning no-result">
																														                        <td colspan="4"><i class="fa fa-warning"></i> No result</td>
																																	                </tr>
																																			            </thead>
																																				                <tbody>
																																						                <?php foreach ($courses as $course): ?>
																																								                    <tr>
																																										                            <td><?= $course["Id"]?></td>
																																													                            <td><?= $course["Title"]?></td>
																																																                            <td><?= $course["Instructor"]?></td>
																																																			                            <td><?= $course["Description"]?></td>
																																																						                        </tr>
																																																									                <?php endforeach ?>
																																																											            </tbody>
																																																												            </table>
																																																													        </div>
																																																														</body>
																																																														</html>