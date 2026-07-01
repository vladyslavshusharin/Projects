import java.util.Random;
import java.util.Scanner;
import java.io.IOException;
import java.util.ArrayList;



public class Main {

    public static void pause(int time){
      try {
      Thread.sleep(time); 
      } 
      catch (InterruptedException e) {
      Thread.currentThread().interrupt();
      }

      for(int i = 0; i < 3; i++){
         System.out.println("");
      }
      
   }
     public static void main(String[] args)  {
         Scanner scan = new Scanner(System.in);
         ArrayList<Fighters> player = new ArrayList<>();

         System.out.println("------- MAGE BS -------");
         for(int i = 0; i < 5; i++){
            System.out.println("");
         }
         System.out.println("Amount of players: ");
         int playerCount = Integer.parseInt(scan.nextLine());

         for(int i = 0; i < playerCount; i++){
            System.out.println("\n Player name " + (i+1) + ": ");
            String playerName = scan.nextLine();
            Fighters newPlayer = null;
            while(newPlayer == null){

               System.out.println("Choose class, player " + (i+1) + ":");
               System.out.println("[1] - Fire Mage");
               System.out.println("[2] - Water Mage");
               System.out.println("[3] - Earth Mage");
               int choice = Integer.parseInt(scan.nextLine());
               switch(choice){
                  case 1:
                     newPlayer = new FireMage(playerName);
                  break;

                  case 2:
                     newPlayer = new WaterMage(playerName);
                  break;

                  case 3:
                     newPlayer = new EarthMage(playerName);
                  break;

                  default:
                     System.out.println("Spatny vyber, vole");
                  break;

               }

            }
            player.add(newPlayer);
            
         }

         for(int i = 0; i < 3; i++){
            System.out.println("");
         }
         System.out.println("-------- START --------");
         for(int i = 0; i < 3; i++){
            System.out.println("");
         }
         int playersAlive = playerCount;
         while(true){

            if(playersAlive == 1){
                  break;
            }

            for(int i = 0; i < playerCount; i++){

               if(player.get(i).getHealth() > 0){
               
                boolean currentPlayerTurn = true;
                int victimNum;
                while(currentPlayerTurn){

                 System.out.println("Hrac " + player.get(i).getName() + " | " 
                                 + "HP: " + player.get(i).getHealth() + " | "
                                 + "MN: " + player.get(i).getMana() + " | "
                                 + "TYPE: " + player.get(i).getType());
                 System.out.println("[1] - Basic Attack");
                 System.out.println("[2] - Special Attack");

                 int move = Integer.parseInt(scan.nextLine());

                 switch(move){
                   case 1:

                     System.out.println("Use on?");
                     for(int p = 0; p < playerCount; p++){
                        if(p != i){
                           System.out.println("[" + (p+1) + "]" + player.get(p).getName());
                        }
                        
                     }
                     victimNum = Integer.parseInt(scan.nextLine());

                     if(victimNum <= playerCount && player.get(victimNum - 1).getHealth() > 0 && victimNum != i+1 && victimNum != 0){
                        player.get(i).BasicAtt(player.get(victimNum - 1));
                        pause(2000);
                        if(player.get(victimNum - 1).getHealth() == 0){
                           playersAlive--;
                        }
                        currentPlayerTurn = false;
                     }else{
                        System.out.println("Player dead or doesn't exist");
                        pause(2000);
                     }

                   break;

                   case 2:

                    System.out.println("Use on?");
                     for(int p = 0; p < playerCount; p++){
                        if(p != i){
                           System.out.println("[" + (p+1) + "]" + player.get(p).getName());
                        }
                        
                     }
                     victimNum = Integer.parseInt(scan.nextLine());

                     if(player.get(i).getMana() < player.get(i).getSpecialCost()){
                        System.out.println("Not enough mana");
                        pause(2000);
                     }
                     else if(victimNum <= playerCount && player.get(victimNum - 1).getHealth() > 0 && victimNum != i+1 && victimNum != 0){
                        player.get(i).SpecialAtt(player.get(victimNum - 1));
                        pause(2000);
                        if(player.get(victimNum - 1).getHealth() == 0){
                           playersAlive--;
                        }
                        currentPlayerTurn = false;
                     }else{
                        System.out.println("Player dead or doesn't exist");
                        pause(2000);
                     }
                     
                   break;
                   default:

                     System.out.println("Spatny vyber");
                     pause(2000);

                   break;
                 }
               
            
                }

               }
               else{
                  continue;
               }

               
            }

         }

         for(int i = 0; i < playerCount; i ++){
            if(player.get(i).getHealth() > 0){
               System.out.println("Hrac " + (i+1) + " vyhral!");
            }
         }
      
     }
}