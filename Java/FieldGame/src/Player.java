import java.util.Random;
import java.util.Scanner;
public class Player extends Field {

    boolean fullfield;
    boolean confirm;
    Random random = new Random();
    Scanner input = new Scanner(System.in);


    public Player(int size1, int size2, int size3){
        super(size1, size2, size3);


    }

    public void show(){
        System.out.println("          ====================");
        System.out.println("PLAYER || ( " + this.colsum[0] + " ) " + " ( " + this.colsum[1] + " ) " + " ( " + this.colsum[2] + " )" + "  Total: { " + this.fieldsum +" }");
        System.out.println("          --------------------");
        super.show();
        System.out.println("          [ " + this.col1[0] + " ] " + " [ " + this.col2[0] + " ] " + " [ " + this.col3[0] + " ]");
        System.out.println("          [ " + this.col1[1] + " ] " + " [ " + this.col2[1] + " ] " + " [ " + this.col3[1] + " ]");
        System.out.println("          [ " + this.col1[2] + " ] " + " [ " + this.col2[2] + " ] " + " [ " + this.col3[2] + " ]");
    }

    public void Checkplfield(int[] owncol1,int[] owncol2,int[] owncol3){
        if(owncol1[0] > 0 && owncol1[1] > 0 && owncol1[2] > 0 &&
           owncol2[0] > 0 && owncol2[1] > 0 && owncol2[2] > 0 &&
           owncol3[0] > 0 && owncol3[1] > 0 && owncol3[2] > 0){
            this.fullfield = true;
        }
        else{this.fullfield = false;}
    }

    public void ColAdd(){
        super.ColAdd();
    }

    public void PlaceNum(int dicenum){
        int choice;
        System.out.println("Choose column: ");
        choice = input.nextInt();
        switch (choice) {
            case 1:
                for (int i = 0; i < 3; i++) {
                    if (col1[i] == 0) {
                        col1[i] = dicenum;
                        this.confirm = true;
                        break;
                        }
                    }
                break;
            case 2:
                for (int i = 0; i < 3; i++) {
                    if (col2[i] == 0) {
                        col2[i] = dicenum;
                        this.confirm = true;
                        break;
                    }
                }
                break;
            case 3:
                for (int i = 0; i < 3; i++) {
                    if (col3[i] == 0) {
                        col3[i] = dicenum;
                        this.confirm = true;
                        break;
                    }
                }
                break;

            default:
                System.out.println("Choose from 1-3...");
                try {
                    Thread.sleep(1000);
                } catch (InterruptedException e) {
                    Thread.currentThread().interrupt();
                }
                break;


            }


    }




}
