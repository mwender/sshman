# SSH Manager

A command line tool for managing your ssh connections.

## Installation

`sshman` is available for installation on your system via [PHIVE](https://phar.io) Once you've installed PHIVE on your system, you can install `sshman` with the following command:

$`phive install mwender/sshman`

Installing with PHIVE takes care of the following:

- Verifies the sshman.phar against my GPG key
- Installs `sshman` on your system with an `sshman` alias

## Setup

Add a `.servers` file to your $HOME directory. Format `.servers` like so:

```
server_name,ip,user(optional),port(optional),ssh_identity(optional)
server.example.com,123.456.78.99,sysadmin,,~/.ssh/identity
server2.example.com,223.14.56.89,"sysadmin,webdev,user3",2222
```

## Building/Compiling

Build sshman.phar by running `box build`.