# KDR

Adds a simple KDR intergration system

# Commands

`/kdr` - View your KDR Statistics\
`/stats <player>` - View a players KDR Statstics\

# Config

```# KDR Plugin Configuration File
# Tags: {kdr} {kills} {deaths} {player}
messages:
  kdr: "§aYour kill/death ratio is {kdr} (Kills: {kills}, Deaths: {deaths})."
  stats: "{player}'s Statistics: KDR: {kdr} (Kills: {kills}, Deaths: {deaths})."
players:
  wockst4rz:
    kills: 0
    deaths: 0
```

I forgot to add {player} in the official config but trust me it works but **ONLY** in the stats option.
