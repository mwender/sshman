# SSH Manager

A command line tool for managing your ssh connections.

## Setup

Add a `.servers` file to your user's $HOME directory. Format `.servers` like so:

```
server_name,ip,user(optional),port(optional),ssh_identity(optional)
server.example.com,123.456.78.99,sysadmin,,~/.ssh/identity
server2.example.com,223.14.56.89,"sysadmin,webdev,user3",2222
```

## Building/Compiling

Build sshman.phar by running `box build`.