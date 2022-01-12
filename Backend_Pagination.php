<?php
function getPaginationString($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=",$category = "&category=",$type = null,$month = null, $year = null)
{	
//TotalItems get
//limit get
	//defaults
	if(!$adjacents) $adjacents = 1;
	if(!$limit) $limit = 5;
	if(!$page) $page = 1;
	if(!$targetpage) $targetpage = "/Window_Panel.php/";
	if($type == "user"){
		$monthLink = "&month=";
		$yearLink = "&year=";
	}else{
		$monthLink = '';
		$yearLink ='';
		$month = null;
		$year = null;
	}
	
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
			$pagination .= "<a href=\"$targetpage$pagestring$prev$category$type$monthLink$month$yearLink$year\">&#8249; prev</a>";
		else
			$pagination .= "<span class=\"disabled\">&#8249; prev</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination .= "<span class=\"current\">$counter</span>";
				else
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type.$monthLink.$month.$yearLink.$year."\">$counter</a>";			
				
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
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type.$monthLink.$month.$yearLink.$year."\">$counter</a>";					
				}
				$pagination .= "<span class=\"elipses\">...</span>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . $category . $type.$monthLink.$month.$yearLink.$year."\">$lpm1</a>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . $category . $type.$monthLink.$month.$yearLink.$year."\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination .= "<a href=\"" . $targetpage . $pagestring . "1".$category . $type.$monthLink.$month.$yearLink.$year."\">1</a>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . "2".$category . $type.$monthLink.$month.$yearLink.$year."\">2</a>";
				$pagination .= "<span class=\"elipses\">...</span>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type.$monthLink.$month.$yearLink.$year."\">$counter</a>";					
				}
				$pagination .= "...";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . $category . $type.$monthLink.$month.$yearLink.$year."\">$lpm1</a>";
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . $category . $type.$monthLink.$month.$yearLink.$year."\">$lastpage</a>";		
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
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . $category . $type.$monthLink.$month.$yearLink.$year."\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination .= "<a href=\"" . $targetpage . $pagestring . $next . $category . $type.$monthLink.$month.$yearLink.$year."\">next &#8250;</a>";
			// $pagination .= "<a href=".'google.com'.">next �</a>";
		else
			$pagination .= "<span class=\"disabled\">next &#8250;</span>";
		$pagination .= "</div>\n";
	}
	return $pagination;
}
?>