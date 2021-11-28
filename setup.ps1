Remove-Item -Path 'C:\xampp\htdocs\leaseme' -recurse
New-Item -Path 'C:\xampp\htdocs\leaseme' -ItemType Directory
Copy-Item -Path 'C:\Users\max\Documents\GitHub\leaseme\*' -Destination 'C:\xampp\htdocs\leaseme' -recurse