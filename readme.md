> [!NOTE]
> 09/12/2024 - *SSHman* has been replaced by [SSHConn](https://github.com/mwender/sshconn).

# SSHman - *manage your SSH connections*

![SSHman - manage your SSH connections](https://raw.githubusercontent.com/mwender/sshman/master/lib/img/sshman-image.png)

*SSHman* is a command line tool for managing your ssh connections.

## Installation

*SSHman* is currently available for MacOS only. Install it on your system via [PHIVE](https://phar.io). Once you've installed PHIVE on your system, you can install *SSHman* with the following command:

$`phive install sshman`

Installing with PHIVE takes care of the following:

- Verifies the sshman.phar against my GPG key
- Installs the sshman.phar with an `sshman` alias

NOTE: The trickest part of the above will probably be installing PHIVE. Once you get PHIVE installed, make sure you have `~/tools` in your `$PATH` as that's where PHIVE will add a simlink to the phars it installs under `~/.phive/phars/`.

## Setup

Add a `.servers` file to your $HOME directory. Format `.servers` like so:

```
server_name,ip,user(optional),port(optional),ssh_identity(optional)
server.example.com,123.456.78.99,sysadmin,,~/.ssh/identity
server2.example.com,223.14.56.89,"sysadmin,webdev,user3",2222
```

## Options

- `-h, --help` - displays HELP
- `-s, --sftp` -  returns an SFTP connection string
- `-v, --version` - displays VERSION info


## Demo

[![asciicast](https://asciinema.org/a/117973.png)](https://asciinema.org/a/117973)

## Changelog

### Version 1.0.3

- Adding `-s, --sftp` option for returning an SFTP connection string

### Version 1.0.2

- Removing phar://sshman.phar/ stream references for PHIVE compatiblity

### Version 1.0.1

- Bugfix: Including HELP and VERSION files

### Version 1.0.0

- Initial release
- Supports multiple users per server by specifying users in a comma separated list (e.g. `admin,sysadmin,root,user1,user2`)
- Option to specify the SSH port for your connection
- Option to specify the identity file for your connection

---

## Building/Compiling

I use [Box](https://github.com/box-project/box2) to build *SSHman*. Once you have *Box* installed on your system, you can build *sshman.phar* by running `box build`.