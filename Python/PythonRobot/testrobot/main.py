#!/usr/bin/env pybricks-micropython
from pybricks.hubs import EV3Brick
from pybricks.ev3devices import (Motor, TouchSensor, ColorSensor,
                                InfraredSensor, UltrasonicSensor, GyroSensor)
from pybricks.parameters import Port, Stop, Direction, Button, Color
from pybricks.tools import wait, StopWatch, DataLog
from pybricks.robotics import DriveBase
from pybricks.media.ev3dev import SoundFile, ImageFile
import time
import random

#This program requires LEGO EV3 MicroPython v2.0 or higher.
# Click "Open user guide" on the EV3 extension tab for more information.


# Create your objects here.
ev3 = EV3Brick()


# Write your program here.

color_sensor = ColorSensor(Port.S2)
button = TouchSensor(Port.S1)
motorsword = Motor(Port.D)
motorshield = Motor(Port.C)

Difficulty = "None"
Class = "None"

EnemyHP = 0
EnemyDMG = 0
EnemyHPFull = 0
EnemyTurn = False
ultimate = 0


PlayerHP = 0
PlayerDMG = 0
PlayerHPFull = 0
PlayerMANA = 0
PlayerMANAFull = 0
Manacost1 = 0
Manacost2 = 0

Stun = False
StunUsedEnemy = False
StunUsedPlayer = False

Proceed = False
Basic = "N"
Ab1 = "N"
Ab2 = "N"



def ability1(PlayerHP, PlayerDMG, PlayerFullHP, EnemHP, EnemHPFull, PlayerMANA, Stun):

  if Class == "Fighter":
    ev3.screen.draw_text(1,50, "Used Brute Strength")
    ev3.speaker.say("OW")
    time.sleep(1)
    ev3.screen.clear()
    ev3.screen.draw_text(1,50, "Dealt" + str((PlayerDMG+PlayerHP*0.15)) + " DMG")
    EnemHP = EnemHP - PlayerDMG + PlayerHP*0.15
    PlayerMANA = PlayerMANA - 20
      
  if Class == "Mage":
    if EnemHP >= EnemHPFull * 0.8:
      ev3.screen.draw_text(1,50, "Shot 3 Mana Orbs")
      ev3.speaker.say("OW")
      time.sleep(1)
      ev3.screen.clear()
      ev3.screen.draw_text(1,50, "Dealt" + str((PlayerDMG * 3)) + " DMG")
      EnemHP = EnemHP - PlayerDMG * 3
      PlayerMANA = PlayerMANA - 30
      
    elif EnemHP >= EnemHPFull * 0.5:
      ev3.screen.draw_text(1,50, "Shot 2 Mana Orbs")
      ev3.speaker.say("OW")
      time.sleep(1)
      ev3.screen.clear()
      ev3.screen.draw_text(1,50, "Dealt" + str((PlayerDMG * 2)) + " DMG")
      EnemHP = EnemHP - PlayerDMG * 2
      PlayerMANA = PlayerMANA - 30
        
    elif EnemHP >= EnemHPFull * 0.2:
      ev3.screen.draw_text(1,50, "Shot 1 Mana Orb")
      ev3.speaker.say("OW")
      time.sleep(1)
      ev3.screen.clear()
      ev3.screen.draw_text(1,50, "Dealt" + str((PlayerDMG * 1.5)) + " DMG")
      EnemHP = EnemHP - PlayerDMG * 1.5
      PlayerMANA = PlayerMANA - 30
    else:
      ev3.screen.draw_text(1,50, "Shot 1 Mana Orb")
      ev3.speaker.say("OW")
      time.sleep(1)
      ev3.screen.clear()
      ev3.screen.draw_text(1,50, "Dealt" + str((PlayerDMG * 1)) + " DMG")
      EnemHP = EnemHP - PlayerDMG * 1
      PlayerMANA = PlayerMANA - 30
      
     
  if Class == "Priest":
    ev3.screen.draw_text(1,50, "Used Sin Punish")
    ev3.speaker.say("OW")
    time.sleep(1)
    ev3.screen.clear()
    ev3.screen.draw_text(1,50, "Dealt" + str((PlayerDMG + 2*(EnemHP/15))) + " DMG")
    EnemHP = EnemHP - PlayerDMG + 2*(EnemHP/15)
    PlayerMANA = PlayerMANA - 20

  return PlayerHP, EnemHP, PlayerMANA, Stun


def ability2(PlayerHP, PlayerDMG, PlayerFullHP, EnemHP, EnemHPFull, PlayerMANA, Stun):

  if Class == "Fighter":
    if EnemHP <= EnemHPFull * 0.25:
      ev3.screen.draw_text(1,50, "Executed the enemy")
      EnemHP = 0
    else: 
      EnemHP = EnemHP - (PlayerDMG + 15)
      ev3.screen.draw_text(1,50, "Used Axe Slash")
      ev3.speaker.say("OOF")
      time.sleep(1)
      ev3.screen.clear()
      ev3.screen.draw_text(1,50,"Dealt" + str((PlayerDMG + 15)) + " DMG")
      Stun = True
      PlayerMANA = PlayerMANA - 25

  if Class == "Mage":
    if PlayerHP > 10:
      ev3.screen.draw_text(1,50,"Used Light Spear")
      ev3.speaker.say("OOF")
      time.sleep(1)
      ev3.screen.clear()
      ev3.screen.draw_text(1,50,"Dealt" + str((PlayerDMG + 2*(PlayerHP/5))) + " DMG")
      ev3.screen.draw_text(1,65,"And lost 10 HP")
      EnemHP = EnemHP - (PlayerDMG + 2*(PlayerHP/5))
      PlayerHP = PlayerHP - 10
      Stun = True
      PlayerMANA = PlayerMANA - 15
    else: 
      ev3.screen.draw_text(1,50,"Used Light Spear")
      ev3.speaker.say("OOF")
      time.sleep(1)
      ev3.screen.clear()
      ev3.screen.draw_text(1,50,"Dealt" + str(PlayerDMG) + " DMG")
      EnemHP = EnemHP - PlayerDMG

  if Class == "Priest":
    ev3.screen.draw_text(1,50,"Used Blessing")
    ev3.speaker.say("Scum")
    time.sleep(1)
    ev3.screen.clear()
    ev3.screen.draw_text(1,65,"Healed for" + str(20) + "HP")
    PlayerHP = PlayerHP + 20
    Stun = True
    PlayerMANA = Playermana - 20

  return PlayerHP, EnemHP, PlayerMANA, Stun


def numgenerator():
  number = random.randint(1,3)
  return number

#ENEMY ABILITY1
def enemyability1(PlayerHP, EnemyDMG, Difficulty):
  multiplier = 0
  if Difficulty == "Easy":
    multiplier = 1
  if Difficulty == "Medium":
    multiplier = 2
  if Difficulty == "Hard":
    multiplier = 3
  
  PlayerHP = PlayerHP - EnemyDMG * (1+multiplier/10)
  ev3.screen.draw_text(5,50, "ENEMY USED MULTISLASH")
  ev3.speaker.say("MULTI SLASH")

  motorsword.run_angle(175, 45*multiplier)
  
  motorsword.run_angle(175, -45*multiplier)
  
  motorsword.run_angle(175, 45*multiplier)
  
  motorsword.run_angle(175, -45*multiplier)

  ev3.screen.clear()
  ev3.screen.draw_text(10,50, "DEALT " + str((EnemyDMG * (1+multiplier/10))) + " DMG")
  
  return PlayerHP

#ENEMY ABILITY2
def enemyability2(PlayerHP, Stun, EnemyDMG, Difficulty):
  if Difficulty == "Easy":
    PlayerHP = PlayerHP - (EnemyDMG - 10)*2

  if Difficulty == "Medium":
    PlayerHP = PlayerHP - EnemyDMG * 1.5

  if Difficulty == "Hard":
    PlayerHP = PlayerHP - EnemyDMG * 1.5 
    Stun = True

  ev3.screen.draw_text(1,50, "ENEMY USED SHIELD BASH")  
  ev3.speaker.say("SHIELD BASH")
  motorshield.run_angle(175, -60)
  
  motorshield.run_angle(175, 60)

  ev3.screen.clear()
  
  if Difficulty == "Easy":
    ev3.screen.draw_text(10,50, "DEALT " + str(((EnemyDMG - 10)*2)) + " DMG")

  if Difficulty == "Medium":
    ev3.screen.draw_text(10,50, "DEALT " + str((EnemyDMG * 2)) + " DMG")

  if Difficulty == "Hard":
    ev3.screen.draw_text(10,50, "DEALT " + str((EnemyDMG * 2)) + " DMG")
    Stun = True
  
  return PlayerHP
         
        

#ENEMY ULTIMATE ABILITY
def enemyultimate(PlayerHP, Difficulty):
  DMG = 0
  if Difficulty == "Easy":
    DMG = 40
  if Difficulty == "Medium":
    DMG = 50
  if Difficulty == "Hard":
    DMG = 60

  PlayerHP = PlayerHP - DMG
  
  ev3.screen.draw_text(10,50, "ENEMY USED ULTIMATE")
  ev3.speaker.say("Bow before my ultimate attack")

  motorshield.run_angle(175, -60)

  motorsword.run_angle(175, 90)
  
  motorsword.run_angle(175, -90)

  motorsword.run_angle(175, 90)
  
  motorsword.run_angle(175, -90)

  motorshield.run_angle(175, 60)
  
  ev3.screen.clear()
  ev3.screen.draw_text(10,50, "DEALT " + str(DMG) + " DMG")
  
  return PlayerHP
  
    




def detect_color():
  color = color_sensor.color()
  if color == Color.RED:
    return "RED"
  elif color == color.GREEN:
    return "GREEN"
  elif color == color.BLUE:
    return "BLUE"


ev3.speaker.beep()

ev3.speaker.say("Welcome, my name is Battl-o-tron and I will fight you")
time.sleep(1)
ev3.screen.draw_text(10,20, "Select a difficulty")
ev3.screen.draw_text(10,35, "R - Easy")
ev3.screen.draw_text(10,50, "G - Medium")
ev3.screen.draw_text(10,65, "B - Hard")
ev3.speaker.say("Please select a difficulty")

while True:
  if button.pressed(): 
    break

ev3.screen.clear()

detect_color()
if detect_color() == "RED":
  Difficulty = "Easy"
  EnemyHP = 140
  EnemyDMG = 15
  EnemyHPFull = 140
  ev3.screen.draw_text(5,20,"Difficulty is Easy")
  ev3.screen.draw_text(5,35, "Stuns: Disabled")
  ev3.speaker.say("You have selected Easy")

elif detect_color() == "GREEN":
  Difficulty = "Medium"
  EnemyHP = 160
  EnemyDMG = 20
  EnemyHPFull = 160
  ev3.screen.draw_text(5,20,"Difficulty is Medium ")
  ev3.screen.draw_text(5,35, "Stuns: Disabled")
  ev3.speaker.say("You have selected Medium")

elif detect_color() == "BLUE":
  Difficulty = "Hard"
  EnemyHP = 190
  EnemyDMG = 25
  EnemyHPFull = 190
  ev3.screen.draw_text(5,20,"Difficulty is Hard ")
  ev3.screen.draw_text(5,35, "Stuns: Enabled")
  ev3.speaker.say("You have selected Hard")

time.sleep(2)
ev3.screen.clear()

Proceed = False
while Proceed != True:
  ev3.screen.draw_text(10,20, "Select a class")
  ev3.screen.draw_text(10,35, "R - Fighter")
  ev3.screen.draw_text(10,50, "G - Mage")
  ev3.screen.draw_text(10,65, "B - Priest")
  ev3.speaker.say("Please select your class")

  while True:
    if button.pressed():
      break

  ev3.screen.clear()


  detect_color()
  if detect_color() == "RED":
    Class = "Fighter"
    PlayerHP = 150
    PlayerDMG = 20
    PlayerHPFull = 150
    PlayerMANA = 100
    PlayerMANAFull = 100
    Manacost1 = 20
    Manacost2 = 25
    Basic = "Punch"
    Ab1 = "Brute Strength"
    Ab2 = "Axe Slash"
    ev3.screen.draw_text(20,5,"Fighter")
    ev3.speaker.say("You are a Fighter")
        
    ev3.screen.draw_text(1,20,"Brute Strength") #Deal DMG based on your HP
    ev3.screen.draw_text(1,35,"Axe Slash") #15 more DMG but execute if enemy is %25 below
    ev3.screen.draw_text(1,50,"Punch") #Deal 20 DMG
  

  elif detect_color() == "GREEN":
    Class = "Mage"
    PlayerHP = 115
    PlayerDMG = 15
    PlayerHPFull = 115
    PlayerMANA = 120
    PlayerMANAFull = 120
    Manacost1 = 30
    Manacost2 = 15
    Basic = "Mana Beam"
    Ab1 = "Mana Orbs"
    Ab2 = "Light Spear"
    ev3.screen.draw_text(20,5,"Mage")
    ev3.speaker.say("You are a Mage")

    ev3.screen.draw_text(1,20,"Mana Orbs") #DMG based on enemy HP
    ev3.screen.draw_text(1,35,"Light Spear") #DMG based on your HP but lose HP
    ev3.screen.draw_text(1,50,"Mana Beam") #Deal 15 DMG


  elif detect_color() == "BLUE":
    Class = "Priest"
    PlayerHP = 120
    PlayerDMG = 10
    PlayerHPFull = 120
    PlayerMANA = 90
    PlayerMANAFull = 90
    Manacost1 = 20
    Manacost2 = 20
    Basic = "Curse"
    Ab1 = "Sin Punish"
    Ab2 = "Blessing"
    ev3.screen.draw_text(30,10,"Priest")
    ev3.speaker.say("You are a Priest")

    ev3.screen.draw_text(1,20,"Sin Punish") #Additional DMG based on enemy HP
    ev3.screen.draw_text(1,40,"Blessing") #Heal yourself
    ev3.screen.draw_text(1,60,"Curse") #Deal 10 DMG


  ev3.screen.draw_text(1,80,"PRESS to continue")
  ev3.screen.draw_text(1,95,"HOLD to return")
  while True:
    if button.pressed():
      Proceed = True
      time.sleep(2)
      if button.pressed():
        Proceed = False
      break
    
    
  ev3.screen.clear()

ev3.screen.draw_text(10, 50, "BATTLE BEGIN")
ev3.speaker.say("PROVE YOURSELF AND FIGHT ME")
ev3.screen.clear()
time.sleep(1)
ev3.speaker.beep()

while PlayerHP > 0 and EnemyHP > 0:
  
  Proceed = False
  
  

  if Stun == True and StunUsedEnemy == False and Difficulty == "Hard":
    Proceed = True
    StunUsedEnemy = True
    ev3.screen.draw_text(20,20, "YOU ARE STUNNED")
    time.sleep(2)
    ev3.screen.clear()
    Stun = False
  else:
    StunUsedEnemy = False
    ev3.screen.draw_text(20,20, "YOUR TURN")
    time.sleep(1)
  
  while Proceed != True:  
    ev3.screen.clear()
    ev3.screen.draw_text(1,5, "HP: " + str(PlayerHP))
    ev3.screen.draw_text(1,20, "MANA: " + str(PlayerMANA))
    ev3.screen.draw_text(1,35, "Robot HP: " + str(EnemyHP))
    ev3.screen.draw_text(1,50, "R-" + str(Basic))
    ev3.screen.draw_text(1,65, "G-" + str(Ab1) + "|M:" + str(Manacost1))
    ev3.screen.draw_text(1,80, "B-" + str(Ab2) + "|M:" + str(Manacost2))

    while True:
      if button.pressed():
        break
        
    ev3.screen.clear()
    detect_color()
    if detect_color() == "RED":
      EnemyHP = EnemyHP - PlayerDMG
      ev3.screen.draw_text(1,50, "You used " + str(Basic))
      time.sleep(1)
      ev3.screen.draw_text(1,50, "Dealt " + str(PlayerDMG))
      time.sleep(2)
      Proceed = True
        
    elif detect_color() == "GREEN":
      if PlayerMANA >= Manacost1:
        PlayerHP, EnemyHP, PlayerMANA, Stun = ability1(PlayerHP, PlayerDMG, PlayerHPFull, EnemyHP, EnemyHPFull, PlayerMANA, Stun)
        time.sleep(2)
        Proceed = True
      else: 
        ev3.screen.draw_text(1,50, "NOT ENOUGH MANA")
        time.sleep(1)
        
    elif detect_color() == "BLUE":
      if PlayerMANA >= Manacost2:
        PlayerHP, EnemyHP, PlayerMANA, Stun = ability2(PlayerHP, PlayerDMG, PlayerHPFull, EnemyHP, EnemyHPFull, PlayerMANA, Stun)
        time.sleep(2)
        Proceed = True
      else: 
        ev3.screen.draw_text(1,50, "NOT ENOUGH MANA")
        time.sleep(1)
   
  ev3.screen.clear()
  
  #Stun checker here + additional hp checker
  
  if EnemyHP <= 0:
    break
  else:  
    EnemyTurn = True
    
  if Stun == True and StunUsedPlayer == False and Difficulty == "Hard":
    EnemyTurn = False
    StunUsedPlayer = True
    ev3.screen.draw_text(20,20, "ENEMY STUNNED")
    time.sleep(2)
    ev3.screen.clear()
    Stun = False
  else:
    StunUsedPlayer = False
    ev3.screen.draw_text(20,20, "ENEMY TURN")
    time.sleep(2)
    ev3.screen.clear()
  
  while EnemyTurn == True:                           #ENEMYTURN
    ultimate = random.randint(1,10)
    if ultimate == 5:
      PlayerHP = enemyultimate(PlayerHP, Difficulty)
      EnemyTurn = False
    else:
      numgenerator() 
      if numgenerator == 1:
        PlayerHP = PlayerHP - EnemyDMG
        ev3.screen.draw_text(10,50, "ENEMY USED BASIC")
        ev3.speaker.say("EN GUARDE")
        motorsword.run_angle(175, 45)
        motorsword.run_angle(175, -45)
        ev3.screen.clear()
        ev3.screen.draw_text(10,50, "DEALT " + str(EnemyDMG) + " DMG")
        time.sleep(2)
        EnemyTurn = False
      elif numgenerator == 2:
        PlayerHP = enemyability1(PlayerHP, EnemyDMG, Difficulty)
        time.sleep(2)
        EnemyTurn = False
      elif numgenerator == 3:
        PlayerHP = enemyability2(PlayerHP, EnemyDMG, Difficulty)
        time.sleep(2)
        EnemyTurn = False
    ev3.screen.clear()
  
  if PlayerMANA != PlayerMANAFull:
    if PlayerMANA >= (PlayerMANAFull-10):
      PlayerMANA = PlayerMANAFull
    else:
      PlayerMANA = PlayerMANA + 10

  if PlayerHP <= 0:
    break
    

if PlayerHP > 0 and EnemyHP <= 0:
  ev3.screen.clear()
  ev3.screen.draw_text(20, 50, "YOU WIN")
  ev3.speaker.say("YOU WIN")
  ev3.speaker.say("FAREWELL, PLAYER")

elif PlayerHP <= 0 and EnemyHP > 0:
  ev3.screen.clear()
  ev3.screen.draw_text(20, 50, "YOU LOSE")
  ev3.speaker.say("YOU LOSE, HAHAHA LOSER, LOSER, LOSER")

exit()