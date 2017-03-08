### DuelsPE
#### Open source PvP plugin for PocketMine-MP.

### Description:
Extensive yet simple PvP plugin for PocketMine-MP, based very roughly on Minifixio's 1vs1 plugin.

Planned Features:
-> Support for an unlimited amount of arenas.
-> Completely automatic, and includes a Player Queue for matches. 
-> Duel your friends!
-> Setting an arena is simple.
-> Signs update automatically to show information regarding the queue/arenas.
-> Extensive API

TODO/Possible ideas:
---
 - [ ] Stable, operational plugin.
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


### How to use:
-> TBA

### Technical:
-> After a fight, the players are teleported back to the spawn of the level defined in config.yml.

-> When a player quits in a fight, his opponent is declared the winner.

-> The arenas and the 1vs1’s signs positions are stored in the data.yml file.

-> When a player quits during the start match countdown, the match stops.


### Commands:
->/duel create [ 1 | 2 | confirm ] - Creates an arena
-> /duel - Joins the arena queue
-> /duel [username] - Sends a duel request to another player


### Notes:
-> This plugin is Open source. Feel free to contribute. Just keep it neat, and use PRs to explain what you plan to add.
-> You can configure many things in this plugin(And hopefully more in the future). Utilizing the config.yml and messages.yml provided with the plugin is encouraged.

-> When /arena 1 or /arena 2 is run, every aspect of your position is saved for the arena. The direction you face when you run the command is given to the player when they join a match.

-> Feel free to make any comments/suggestions for this plugin. For issues, please be descriptive and use the issue tracker in the GitHub repo. If you want to contribute, make a Pull Request.
