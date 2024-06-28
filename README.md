# Try it out at https://gbtptc.isledelfino.net
# Account.dat Value Generator
Tries to generate VALID values for the account.dat on what the Pretendo website used to generate before they removed the option to get your files from it. For Cemu only
### YOU STILL NEED A VALID OTP.BIN AND A SEEPROM.BIN FILE TO CONNECT. I CAN'T GENERATE THESE, BUT THIS SHOULD BE ENOUGH IF YOU ALREADY HAVE THESE.
# What values are being returned properly
- [x] PID
- [x] Mii Data
- [x] Mii Name
- [x] Uuid
- [x] Password Hash Cache
# FAQ - How do I use this on an account.dat file?
This tool generates the values on account.dat that you mostly need to connect online with Pretendo Network. These include the password hash, principal ID, mii data and mii name.
You can generate the values using the Calculator and the pass-hash files. The pass-hash does not send your password ANYWHERE.
After you got the values, you can just copy & paste them on the base account.dat that's in this repo.

# FAQ - Does this work with Nintendo Network?
It **COULD** work with it. It has been only tested with Pretendo so far, but feel free to test it on Nintendo Network.

# FAQ - Does it work with apps like Miiverse?
No. Cemu won't be able to generate a valid ParamPack request header because the account.dat file is missing the "TransferableIdBase", "UtcOffset" and "TimeZoneId" parameters. I still didn't find out how these values are determined by the Wii U OS, but the values this repo aims to generate should be more than enough for you to play games online and mostly connect to the friends list.
