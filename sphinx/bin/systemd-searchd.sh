#!/usr/bin/env bash
#!/bin/sh

#  echo My name is Vasya
# CONFIGFILE="/home/m/marsin/fitness/public_html/search_box/sphinx/etc/sphinx.conf"
# SPHINX="/home/m/marsin/fitness/public_html/search_box/sphinx/bin/searchd -c $CONFIGFILE"

# [[ -z $1 ]] && { echo "Usage: $(basename $0) (start|stop|restart|status)"; exit 0; }

# case "$1" in
#   start)
#   $SPHINX
#   ;;
#   stop)
#      $SPHINX --stop
#   ;;
#    restart)
#      $SPHINX --stop
#      sleep 2
#      $SPHINX
#   ;;
#   status)
#      $SPHINX --status
#    ;;
#    *)
#      echo "Unknown option $1"
#    ;;
# esac


case $1 in
    start)
        /home/m/marsin/fitness/public_html/search_box/sphinx/bin/searchd
        echo "Sphinx searchd started."
        ;;
    stop)
        /home/m/marsin/fitness/public_html/search_box/sphinx/bin/searchd --stop
        echo "Sphinx searchd stoped."
        ;;
    restart)
        /home/m/marsin/fitness/public_html/search_box/sphinx/bin/searchd --stop
        sleep 1
        /home/m/marsin/fitness/public_html/search_box/sphinx/bin/searchd
        echo "Sphinx searchd restart complete."
        ;;
    *)
        echo "Usage: systemctl {start|stop|restart} searchd.service"
        exit 1
esac
 
exit 0