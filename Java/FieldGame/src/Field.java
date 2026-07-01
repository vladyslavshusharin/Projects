import java.util.Random;
import java.util.Scanner;

public class Field {

    static boolean fullfields;
    static Random random = new Random();
    static int dicenum;

    int[] col1;
    int[] col2;
    int[] col3;

    int[] colsum = new int[3];

    int fieldsum = 0;

    public Field(int size1, int size2, int size3){
        this.col1 = new int[size1];
        this.col2 = new int[size2];
        this.col3 = new int[size3];

    }

   public static void ClearSpace(){
        for(int i = 0; i < 30; i++){
            System.out.println(" ");
        }
   }

   public static void Pause(int time){
       try {
           Thread.sleep(time);
       } catch (InterruptedException e) {
           Thread.currentThread().interrupt();
       }
   }

    public static void rolldice(){
        dicenum = random.nextInt(6) + 1;
    }
    public void show(){
       for(int k = 0; k < 2; k++) {
           for (int i = 0; i < 3; i++) {
               if (i < 2) {
                   if (this.col1[i] > 0 && this.col1[i + 1] == 0) {
                       int temp = this.col1[i];
                       this.col1[i] = this.col1[i + 1];
                       this.col1[i + 1] = temp;
                   }
               }
           }
           for (int i = 0; i < 3; i++) {
               if (i < 2) {
                   if (this.col2[i] > 0 && this.col2[i + 1] == 0) {
                       int temp = this.col2[i];
                       this.col2[i] = this.col2[i + 1];
                       this.col2[i + 1] = temp;
                   }
               }
           }
           for (int i = 0; i < 3; i++) {
               if (i < 2) {
                   if (this.col3[i] > 0 && this.col3[i + 1] == 0) {
                       int temp = this.col3[i];
                       this.col3[i] = this.col3[i + 1];
                       this.col3[i + 1] = temp;
                   }
               }
           }
       }


    }

    public static int[] CheckEnemy(int[] owncol, int[] enemcol){

        for(int i = 0; i < 3; i++){
            if(owncol[i] == enemcol[0]){
                enemcol[0] = 0;
            }
            if(owncol[i] == enemcol[1]){
                enemcol[1] = 0;
            }
            if(owncol[i] == enemcol[2]){
                enemcol[2] = 0;
            }
        }

        return enemcol;
    }

    public static void Checkfields(int[] owncol1,int[] owncol2,int[] owncol3, int[] enemcol1, int[] enemcol2, int[] enemcol3){
        if(owncol1[0] > 0 && owncol1[1] > 0 && owncol1[2] > 0 &&
           owncol2[0] > 0 && owncol2[1] > 0 && owncol2[2] > 0 &&
           owncol3[0] > 0 && owncol3[1] > 0 && owncol3[2] > 0 &&
           enemcol1[0] > 0 && enemcol1[1] > 0 && enemcol1[2] > 0 &&
           enemcol2[0] > 0 && enemcol2[1] > 0 && enemcol2[2] > 0 &&
           enemcol3[0] > 0 && enemcol3[1] > 0 && enemcol3[2] > 0){

            fullfields = true;
        }

    }


    public void ColAdd(){
        int[] dicenum = {0,0,0,0,0,0};
        //COLUMN1
        for(int i = 0; i < this.col1.length; i++){
            if(this.col1[i] != 0){
            dicenum[this.col1[i]-1] = dicenum[this.col1[i]-1] + 1;}
        }
        for(int i = 0; i < dicenum.length; i++){
            if(dicenum[i] == 1){
                this.colsum[0] = this.colsum[0] + i+1;
            }
            if(dicenum[i] == 2){
                this.colsum[0] = this.colsum[0] + ((i+1)*2)*2;
            }
            if(dicenum[i] == 3){
                this.colsum[0] = this.colsum[0] + ((i+1)*3)*3;
            }
        }
        //nullify
        for(int i = 0; i < dicenum.length; i++){
            dicenum[i] = 0;
        }
        //COLUMN2
        for(int i = 0; i < this.col2.length; i++){
            if(this.col2[i] != 0){
            dicenum[this.col2[i]-1] = dicenum[this.col2[i]-1] + 1;}
        }
        for(int i = 0; i < dicenum.length; i++){
            if(dicenum[i] == 1){
                this.colsum[1] = this.colsum[1] + i+1;
            }
            if(dicenum[i] == 2){
                this.colsum[1] = this.colsum[1] + ((i+1)*2)*2;
            }
            if(dicenum[i] == 3){
                this.colsum[1] = this.colsum[1] + ((i+1)*3)*3;
            }
        }
        //nullify
        for(int i = 0; i < dicenum.length; i++){
            dicenum[i] = 0;
        }
        //COLUMN3
        for(int i = 0; i < this.col3.length; i++){
            if(this.col3[i] != 0){
            dicenum[this.col3[i]-1] = dicenum[this.col3[i]-1] + 1;}
        }
        for(int i = 0; i < dicenum.length; i++){
            if(dicenum[i] == 1){
                this.colsum[2] = this.colsum[2] + i+1;
            }
            if(dicenum[i] == 2){
                this.colsum[2] = this.colsum[2] + ((i+1)*2)*2;
            }
            if(dicenum[i] == 3){
                this.colsum[2] = this.colsum[2] + ((i+1)*3)*3;
            }
        }

        this.fieldsum = this.colsum[0] + this.colsum[1] + this.colsum[2];


    }
}




