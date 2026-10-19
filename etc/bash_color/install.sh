#!/bin/bash

cat > ~/.terminal_color << 'EOF'
MYIP=$(ip -4 route get 1.1.1.1 2>/dev/null | awk '{for(i=1;i<=NF;i++) if($i=="src") print $(i+1)}')
MYIP=${MYIP:-no-ip}

#rootなら赤、それ以外は緑
if [ "$EUID" -eq 0 ]; then
  COLOR='\[\e[1;31m\]'
else
  COLOR='\[\e[1;32m\]'
fi
RESET='\[\e[0m\]'

PS1="${COLOR}[\u@\h(${MYIP}):\w]${RESET} > "
EOF

echo '#色設定' >> ~/.bashrc
echo 'source ~/.terminal_color' >> ~/.bashrc
