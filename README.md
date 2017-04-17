# [WIP] DuelsPE
### Open source, in-dev PvP plugin for [PocketMine-MP](pmmp.io).

[![Poggit-CI](https://poggit.pmmp.io/ci.badge/corytortoise/DuelsPE/DuelsPE)](https://poggit.pmmp.io/ci/corytortoise/DuelsPE/DuelsPE)

## Description:
Simple PvP plugin for PocketMine-MP, based very roughly on Minifixio's 1vs1 plugin. Unfinished. Don't even try to use this plugin yet.

## How do I use this plugin?
Like any other PocketMine plugin, download the plugin, either as a phar file, or straight from GitHub, if you are a developer. Add the plugin to your server's plugins folder. Restart your server, and the plugin should load. If it does not, please refer to the FAQ below. Otherwise, you may immediately use the plugin as it is, or configure it to your liking with the config.yml and messages.yml files.

After your plugin is loaded, you may use the command /duel [args...] in-game. Click here(TBA) to see a full explanation of the command and it's subcommands.

Once you have created an arena, players can use /duel, /duel join, or /duel [opponentname] to join a match, assuming the queue is not full.

##FAQ

Q: "Why isn't my plugin loading?"
A: Are any errors or warnings preset on your server console when the server is started? These typically give you an idea of the problem.

Q: "How can I solve the 'Incompatible API Version' message?"
A: This means that the version number in the DuelsPE plugin.yml is different from the API version of your server.You can edit it to match the version of your server, but I will try to keep the API version here updated myself.

Q: "How can I contribute to this project?"
A: This is a question you should be asking yourself. Frankly, I won't(and can't) give you anything valuable in return for helping on this project. Anything, from a simple typo fix, to rewriting entire classes, will benefit everyone who uses the plugin. If you want to help, fork this repository and create a Pull Request.

##To Do List:
---
 - [ ] Stable, operational plugin.
 - [ ] Spectate after death.
 - [ ] Support different languages.
 - [ ] Status/Join signs for matches.
 - [ ] Duel friends with command
 - [ ] Custom Kit support (Maybe support a kit plugin like AdvancedKits?)
 - [ ] Support different kits per arena.
 - [ ] Allow more than one round per match. (Majority of X kills wins the match)
 - [ ] 2v2, 3v3, etc.? (Lot of work here.)
 - [ ] Support arena names and creators?
   - Example: When player joins arena: "You joined a 1vs1 against {opponent} on {ArenaName} by {ArenaMaker}"
 - [ ] Stats system or extension plugin? (Extend API to allow this)
 - [ ] Submit to Poggit so that more people can use the plugin. :)
 - [ ] Make the best PocketMine PvP plugin ever seen.

### Commands:
-> /duel create [ 1 | 2 | confirm ] - Creates an arena

-> /duel - Joins the arena queue

-> /duel [username] - Sends a duel request to another player

### Credits:

 - Much of the kit system is inspired by AdvancedKits by Luca28pet. 

 - Credit to these people for helping:
  - sero583
  - uselesswaifu
