phpbb-3.1-no-quote-in-topic
=========================

phpBB 3.1 extension will disallow the quoting of posts.  There is a constant set in the listener file to allow the extension to ignore admins and mods.  Read the listener file to de-activate as this extension will ignore admins and mods.

[![Build Status](https://travis-ci.org/RMcGirr83/phpBB-3.1-no-quote-in-topic.svg?branch=master)](https://travis-ci.org/RMcGirr83/phpBB-3.1-no-quote-in-topic)
## Installation

### 1. clone
Clone (or download and move) the repository into the folder ext/rmcgirr83/noquoteintopic:

```
cd phpBB3
git clone https://github.com/rmcgirr83/phpBB-3.1-no-quote-in-topic.git ext/rmcgirr83/noquoteintopic/
```

### 2. activate
Go to admin panel -> tab customise -> Manage extensions -> enable No Quote In Topic

## Update instructions:
1. Go to you phpBB-Board > Admin Control Panel > Customise > Manage extensions > No Quote In Topic: disable
2. Delete all files of the extension from ext/rmcgirr83/noquoteintopic
3. Upload all the new files to the same locations
4. Go to you phpBB-Board > Admin Control Panel > Customise > Manage extensions > No Quote In Topic: enable
5. Purge the board cache
