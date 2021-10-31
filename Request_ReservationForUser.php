<?php
//returns array of reservation 
$userID = $_REQUEST["var"];
$page = $_REQUEST['page'];
$reservation = array();
include "db_connection.php";
$conn = OpenCon();
$limit = 2;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;	
    $query = "SELECT COUNT(*) as num FROM tbl_reservation WHERE r_user_ID = ? and r_status = 0 AND r_startDateAndTime > CURRENT_DATE()";
		$sql5=$conn->prepare($query);
        $sql5->bind_param("i", $userID);
			$sql5->execute();
			$result2 = $sql5->get_result();
			$user = $result2->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();
$sql_code = "SELECT * FROM tbl_reservation INNER JOIN tbl_room ON tbl_reservation.r_room_ID = tbl_room.room_ID WHERE tbl_reservation.r_user_ID = ? AND tbl_reservation.r_startDateAndTime > CURRENT_DATE() LIMIT $start, $limit";
if($sql= $conn->prepare($sql_code)){
    $sql->bind_param('i',$r_user);
    $r_user = $userID;
    if($sql->execute()){
        $result = $sql->get_result();
        while($row = $result->fetch_assoc()){
            $reservation[] = array(
                'event' => $row["r_event"],
                'start' => $row["r_startDateAndTime"],
                'end' => $row["r_endDateAndTime"],
                'approval' => $row['r_approved_ID'],
                'reservationID' => $row["r_ID"],
                'status' => $row['r_status'],
                'room' => $row['room_name'],
                'userID' => $row['r_user_ID']
            ); 
        }
    }
    $sql->close();
}
$conn->close();
$pagination = getPaginationString($page,$total_items,$limit,false,'/Window_AdminPanel.php/',"?page=","&category=");
if(count($reservation) != 0){
    $reservation[count($reservation)-1]+=array(
        'pagination' => $pagination
    );
}
$myJSON = json_encode($reservation);
echo $myJSON;
function getPaginationString($page = 1, $totalitems, $limit = 4, $adjacents = 1, $targetpage = "/", $pagestring = "?page=",$category = "&category=")
{	
 $type = 'user';
//TotalItems get
//limit get
	//defaults
	if(!$adjacents) $adjacents = 1;
	if(!$limit) $limit = 4;
	if(!$page) $page = 1;
	if(!$targetpage) $targetpage = "Window_AdminPanel.php/";
    

	//other vars
	$prev = $page - 1;									//previous page is page - 1
	$next = $page + 1;									//next page is page + 1
	$lastpage = ceil($totalitems / $limit);				//lastpage is = total items / items per page, rounded up.
	$lpm1 = $lastpage - 1;								//last page minus 1
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\"";
		// if($margin || $padding)
		// {
		// 	$pagination .= " style=\"";
		// 	if($margin)
		// 		$pagination .= "margin: $margin;";
		// 	if($padding)
		// 		$pagination .= "padding: $padding;";
		// 	$pagination .= "\"";
		// }
		$pagination .= ">";
		//previous button
		if ($page > 1) 
			$pagination .= "<a href=\"$targetpage$pagestring$prev$category$type\"> < prev</a>";
		else
			$pagination .= "<span class=\"disabled\"> < prev</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination .= "<span class=\"current\">$counter</span>";
				else
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type."\">$counter</a>";			
				
			}
		}
		elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
		{
          
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 3))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type."\">$counter</a>";					
				}
				$pagination .= "<span class=\"elipses\">...</span>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . $category . $type."\">$lpm1</a>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . $category . $type."\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination .= "<a href=\"" . $targetpage . $pagestring . "1".$category . $type."\">1</a>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . "2".$category . $type."\">2</a>";
				$pagination .= "<span class=\"elipses\">...</span>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type."\">$counter</a>";					
				}
				$pagination .= "...";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . $category . $type."\">$lpm1</a>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . $category . $type."\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination .= "<a href=\"" . $targetpage . $pagestring . "1\">1</a>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . "2\">2</a>";
				$pagination .= "<span class=\"elipses\">...</span>";
				for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type."\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination .= "<a href=\"" . $targetpage . $pagestring . $next . $category . $type."\">next ></a>";
			// $pagination .= "<a href=".'google.com'.">next �</a>";
		else
			$pagination .= "<span class=\"disabled\">next ></span>";
		$pagination .= "</div>\n";
	}
	return $pagination;
}

