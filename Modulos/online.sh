   #!/bin/bash

 function onapp1() {
        clear
        echo -e "\n\033[1;32mInstall the function to check people online... \033[0m"
        echo ""
        apt install apache2 -y >/dev/null 2>&1
        sed -i "s/Listen 80/Listen 82/g" /etc/apache2/ports.conf >/dev/null 2>&1
        service apache2 restart
        rm -rf /var/www/html/server >/dev/null 2>&1
        mkdir /var/www/html/server >/dev/null 2>&1
        fun_bar 'screen -dmS onlineapp onlineapp' 'sleep 3'
        [[ $(grep -wc "onlineapp" /etc/autostart) = '0' ]] && {
            echo -e "ps x | grep 'onlineapp' | grep -v 'grep' && echo 'ON' || screen -dmS onlineapp onlineapp" >>/etc/autostart
        } || {
            sed -i '/onlineapp/d' /etc/autostart
            echo -e "ps x | grep 'onlineapp' | grep -v 'grep' && echo 'ON' || screen -dmS onlineapp onlineapp" >>/etc/autostart
        }
        IP=$(wget -qO- ipv4.icanhazip.com) >/dev/null 2>&1
        echo -e "\n\033[1;32m  ONLINE APP ATIVO !\033[0m"
        echo -e "\033[1;31m \033[1;33mURL de Usuários Online para usar no App\033[0m"
        echo -e " http://$IP:82/server/online"
        sleep 10
        menu
    }
    function onapp2() {
        clear
        echo -e "\033[1;32mPARANDO O ONLINE APP... \033[0m"
        echo ""
        fun_stponlineapp() {
            sleep 1
            screen -r -S "onlineapp" -X quit
            screen -wipe 1>/dev/null 2>/dev/null
            [[ $(grep -wc "onlineapp" /etc/autostart) != '0' ]] && {
                sed -i '/onlineapp/d' /etc/autostart
            }
            sleep 1
        }

        fun_bar 'fun_stponlineapp' 'sleep 3'
        rm -rf /var/www/html/server >/dev/null 2>&1
        echo -e "\n\033[1;31m ONLINE APP PARADO !\033[0m"
        sleep 3
        menu
    }
    function onapp_ssh() {
        [[ $(ps x | grep "onlineapp" | grep -v grep | wc -l) = '0' ]] && onapp1 || onapp2
    }
