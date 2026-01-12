/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2026 IcrediBB Design Team         **
\***************************************************/


.:| Installation |:.
1) Unzip all contents of the compressed file into your web server.

If on *nix:
Chmod the file 'database.php' 777

2) Open up installer.php in your web browser. Follow instructions.

3) Set up categories and forums via AdminCP.

4) Get your community going.



.:| Upgrading |:.
1) Unzip all contents of the compressed file into your web server, overwriting the originals.

If on *nix:
Chmod the folder 'themes' 777
Chmod the folder 'avatars' 777
Chmod the folder 'avatars/users' 777

2) Open up upgrader.php in your web browser. Follow instructions.

3) Go and have some fun with the new features



.:| Troubleshooting |:.
1 Q) Problem:
When using the installer on the mysql part, it will say no database 
selected.
1 A) Solution:
Make sure database.php is chmod 777 on *nix and that you have 
supplied correct database name.

2 Q) Problem:
When using the installer, I typed the password incorrectly the first time, went back 
and tried to do the right one, but it didn't work. It gave me the same error message.
2 A) Solution:
Once the database.php file is written, it can't be changed. This is for security reasons.
You will need to reinsert the original database.php file into the server.

3 Q) Problem:
I am on a server running IIS. When I try to login, it never changes from Guest.
3 A) Solution:
This will require a change in the setup files for the php.ini file. Please send the following
information to your host:

allow_call_time_pass_reference = On
display_errors = Off         <-- This will cause IcrediBB to stop functioning if it's on. 
register_globals = On
register_argc_argv = On
magic_quotes_gpc = On
include_path = ".;c:\php"    <-- Notice the period, not a comma before the semicolon.
cgi.force_redirect = 0       <-- MUST be 0 or Off when using IIS.
c:/php/extensions/           <-- Notice the *forward* slashes - important.
allow_url_fopen = On
define_syslog_variables  = On
session.referer_check =      <-- IIS & PHP work *much* better together of this is blank or 0.

session.use_trans_sid = 1    <-- This should be fine but if there are session problems (i.e. the session ID in the URL) change to 0.

