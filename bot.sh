#!/bin/bash
# Colors
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"


echo -e "$COL_RED                                                                       $COL_RESET"
echo -e "$COL_RED                ****************                     $COL_RESET"
echo -e "$COL_RED                * | $COL_CYAN iBot $COL_RED  | *   				         $COL_RESET"
echo -e "$COL_RED                ****************               	  $COL_RESET"


 
if [[ $1 == 'stop' ]]; then 
        echo stop >> ./cache/log.txt
	date >> ./cache/log.txt
        screen -S bot -X quit
		sleep 1
		echo -e "Status: $COL_RED wylaczony! $COL_RESET"
elif [[ $1 == 'start' ]]; then
	sleep 1
	echo start >> ./cache/log.txt
	date >> ./cache/log.txt
        screen -dmS bot php core.php
		ps ax | grep -v grep | grep -v -i SCREEN | grep links >> ./cache/log.txt	
		echo -e "Status: $COL_GREEN wlaczony! $COL_RESET"
else
	echo -e "$COL_GREEN Użyj: ${0} {start/stop} $COL_RESET"
fi