<h1 align="center">DustToAsh.org</h1>
<h1 align="center"><img width="150px" height="150px" src="/dusttoash.org/favicon.ico"></img></h1>
<br><br>

<p align="center"><i><q>This is a website...</q></i></p>

## Intro
Welcome to the repository for `dusttoash.org`.

## Navigation
In the root of the repository, you should see a few directories with names like those of a domain, (most notably the folder [`dusttoash.org`](/dusttoash.org)). The way this website is set up, is that the server serves files from the directory that matches the domain used to connect. For example, if someone tried to access http://test.dusttoash.org/somefile, the web server would serve the file [/test.dusttoash.org/somefile/index.php](/test.dusttoash.org/somefile/index.php), to the connector. The domain name used is the folder that files are served from.

If a user requests a resource that has no extension (i.e., the user tries to access something like `http://dusttoash.org/file` instead of `http://dusttoash.org/file.txt`), then the website will search for a file named `file` with a valid servable-file extension, like `.html` or `.php`.

## Website
The website is usually up and running at [`dusttoash.org`](http://dusttoash.org), which should reflect whatever version of this repository the server has at the time the site is visited. If you're here to contribute to the repo, please send a pull request or modify files or whatever. The `main` branch is the branch that the server serves.

## Other Stuff
Documentation and stuff will probably be added to this repo eventually. In the mean time, submit an issue or something if you're curious about something, or if there's an actual issue, or if you're really really bored.
