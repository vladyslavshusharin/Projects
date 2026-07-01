import java.util.Random;
import java.util.Scanner;
import java.io.IOException;




public class Main {
    public static void main(String[] args)  {
        System.out.println("Hello world!");


        Player plfield = new Player(3,3,3);
        Enemy enemfield = new Enemy(3,3,3);

        plfield.col1[0] = 0; plfield.col2[0] = 0; plfield.col3[0] = 0;
        plfield.col1[1] = 0; plfield.col2[1] = 0; plfield.col3[1] = 0;
        plfield.col1[2] = 0; plfield.col2[2] = 0; plfield.col3[2] = 0;

        enemfield.col1[0] = 0; enemfield.col2[0] = 0; enemfield.col3[0] = 0;
        enemfield.col1[1] = 0; enemfield.col2[1] = 0; enemfield.col3[1] = 0;
        enemfield.col1[2] = 0; enemfield.col2[2] = 0; enemfield.col3[2] = 0;

        while(Field.fullfields != true){

            plfield.Checkplfield(plfield.col1, plfield.col2, plfield.col3);
            Field.rolldice();
           while(plfield.confirm != true && plfield.fullfield != true){
               plfield.colsum[0] = 0; enemfield.colsum[0] = 0;
               plfield.colsum[1] = 0; enemfield.colsum[1] = 0;
               plfield.colsum[2] = 0; enemfield.colsum[2] = 0;
               Field.ClearSpace();
               System.out.println("           Y O U R  T U R N");
               for(int i = 0; i < 3; i++){System.out.println();}
               enemfield.ColAdd();
               plfield.ColAdd();
               enemfield.show();
               plfield.show();
               System.out.println();
               System.out.println("Rolled number: " + Field.dicenum);
               System.out.println();
               plfield.PlaceNum(Field.dicenum);
           }

            plfield.confirm = false;
            plfield.colsum[0] = 0; enemfield.colsum[0] = 0;
            plfield.colsum[1] = 0; enemfield.colsum[1] = 0;
            plfield.colsum[2] = 0; enemfield.colsum[2] = 0;
            Field.ClearSpace();
            System.out.println("           Y O U R  T U R N");
            for(int i = 0; i < 3; i++){System.out.println();}
            enemfield.ColAdd();
            plfield.ColAdd();
            enemfield.show();
            plfield.show();
            for(int i = 0; i < 4; i++){System.out.println();}
            Field.Pause(2500);

            Field.CheckEnemy(plfield.col1, enemfield.col1);
            Field.CheckEnemy(plfield.col2, enemfield.col2);
            Field.CheckEnemy(plfield.col3, enemfield.col3);
            plfield.colsum[0] = 0; enemfield.colsum[0] = 0;
            plfield.colsum[1] = 0; enemfield.colsum[1] = 0;
            plfield.colsum[2] = 0; enemfield.colsum[2] = 0;
            Field.ClearSpace();
            System.out.println("          E N E M Y  T U R N");
            for(int i = 0; i < 3; i++){System.out.println();}
            enemfield.ColAdd();
            plfield.ColAdd();
            enemfield.show();
            plfield.show();

            Field.Checkfields(plfield.col1, plfield.col2, plfield.col3, enemfield.col1, enemfield.col2, enemfield.col3);
            if(Field.fullfields == true){
                break;
            }

            for(int i = 0; i < 4; i++){System.out.println();}
            System.out.print("Enemy rolling dice");
            for(int i = 0; i < 3; i++){
                System.out.print(".");
                Field.Pause(1000);
            }


            Field.rolldice();
            enemfield.Checkenemfield(enemfield.col1, enemfield.col2, enemfield.col3);

           while(enemfield.confirm == false && enemfield.fullfield != true){
               plfield.colsum[0] = 0; enemfield.colsum[0] = 0;
               plfield.colsum[1] = 0; enemfield.colsum[1] = 0;
               plfield.colsum[2] = 0; enemfield.colsum[2] = 0;
               Field.ClearSpace();
               System.out.println("          E N E M Y  T U R N");
               for(int i = 0; i < 3; i++){System.out.println();}
               enemfield.ColAdd();
               plfield.ColAdd();
               enemfield.show();
               plfield.show();
               System.out.println();
               System.out.println("Enemy number: " + Field.dicenum);
               enemfield.PlaceNum(Field.dicenum);
           }
            System.out.println();
            System.out.println("Enemy choosing column");
            for(int i = 0; i < 3; i++){
                System.out.print(".");
                Field.Pause(1000);
            }
            enemfield.confirm = false;
            plfield.colsum[0] = 0; enemfield.colsum[0] = 0;
            plfield.colsum[1] = 0; enemfield.colsum[1] = 0;
            plfield.colsum[2] = 0; enemfield.colsum[2] = 0;
            Field.ClearSpace();
            System.out.println("          E N E M Y  T U R N");
            for(int i = 0; i < 3; i++){System.out.println();}
            enemfield.ColAdd();
            plfield.ColAdd();
            enemfield.show();
            plfield.show();
            for(int i = 0; i < 4; i++){System.out.println();}
            Field.Pause(3500);

            Field.CheckEnemy(enemfield.col1, plfield.col1);
            Field.CheckEnemy(enemfield.col2, plfield.col2);
            Field.CheckEnemy(enemfield.col3, plfield.col3);
            plfield.colsum[0] = 0; enemfield.colsum[0] = 0;
            plfield.colsum[1] = 0; enemfield.colsum[1] = 0;
            plfield.colsum[2] = 0; enemfield.colsum[2] = 0;
            Field.ClearSpace();
            System.out.println("           Y O U R  T U R N");
            for(int i = 0; i < 3; i++){System.out.println();}
            enemfield.ColAdd();
            plfield.ColAdd();
            enemfield.show();
            plfield.show();

            Field.Checkfields(plfield.col1, plfield.col2, plfield.col3, enemfield.col1, enemfield.col2, enemfield.col3);
            if(Field.fullfields == true){
                break;
            }
            for(int i = 0; i < 4; i++){System.out.println();}
            System.out.println("Rolling dice");
            for(int i = 0; i < 3; i++){
                System.out.print(".");
                Field.Pause(1000);
            }
        }

        for(int i = 0; i < 5; i++){System.out.println();}

        if(plfield.fieldsum > enemfield.fieldsum){
            System.out.println("YOU WIN");
        }
        if(enemfield.fieldsum > plfield.fieldsum){
            System.out.println("YOU LOSE");
        }
        if(enemfield.fieldsum == plfield.fieldsum){
            System.out.println("DRAW");
        }

        System.out.println("Your score: { " + plfield.fieldsum + " } ");
        System.out.println("Enemy score: { " + enemfield.fieldsum + " } ");






    }
}