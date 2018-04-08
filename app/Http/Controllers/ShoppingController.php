if ($dayWeek ==1){
if ($tmark=='A'||$tmark=='B'||$tmark=='C'){$date=$today;}
if ($tmark=='D'||$tmark=='E'||$tmark=='F'){$date=date("Y-m-d",strtotime("+1 day"));}
if ($tmark=='G'||$tmark=='H'||$tmark=='I'){$date=date("Y-m-d",strtotime("+2 day"));}
if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=date("Y-m-d",strtotime("+3 day"));}
if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+4 day"));}
if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+5 day"));}
if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+6 day"));}
}elseif($dayWeek ==2){
if ($tmark=='D'||$tmark=='E'||$tmark=='F'){$date=$today;}
if ($tmark=='G'||$tmark=='H'||$tmark=='I'){$date=date("Y-m-d",strtotime("+1 day"));}
if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=date("Y-m-d",strtotime("+2 day"));}
if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+3 day"));}
if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+4 day"));}
if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+5 day"));}
}elseif($dayWeek ==3){
if ($tmark=='G'||$tmark=='H'||$tmark=='I'){$date=$today;}
if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=date("Y-m-d",strtotime("+1 day"));}
if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+2 day"));}
if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+3 day"));}
if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+4 day"));}
}elseif($dayWeek ==4){
if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=$today;}
if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+1 day"));}
if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+2 day"));}
if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+3 day"));}
}elseif($dayWeek ==5){
if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=$today;}
if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+1 day"));}
if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+2 day"));}
}elseif($dayWeek ==6){
if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=$today;}
if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+1 day"));}
}elseif($dayWeek ==7 || $dayWeek==0){
if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=$today;}
}