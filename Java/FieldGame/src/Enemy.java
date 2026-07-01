import java.util.Random;
public class Enemy extends Field {

    boolean fullfield;
    boolean confirm;

    Random random = new Random();



    public Enemy(int size1, int size2, int size3){
        super(size1, size2, size3);


    }

    public void show(){
        super.show();
        System.out.println("          [ " + this.col1[2] + " ] " + " [ " + this.col2[2] + " ] " + " [ " + this.col3[2] + " ]");
        System.out.println("          [ " + this.col1[1] + " ] " + " [ " + this.col2[1] + " ] " + " [ " + this.col3[1] + " ]");
        System.out.println("          [ " + this.col1[0] + " ] " + " [ " + this.col2[0] + " ] " + " [ " + this.col3[0] + " ]");
        System.out.println("          --------------------");
        System.out.println("ENEMY  || ( " + this.colsum[0] + " ) " + " ( " + this.colsum[1] + " ) " + " ( " + this.colsum[2] + " )" + "  Total: { " + this.fieldsum +" }");




    }

    public void Checkenemfield(int[] enemcol1, int[] enemcol2, int[] enemcol3){
        if(enemcol1[0] > 0 && enemcol1[1] > 0 && enemcol1[2] > 0 &&
           enemcol2[0] > 0 && enemcol2[1] > 0 && enemcol2[2] > 0 &&
           enemcol3[0] > 0 && enemcol3[1] > 0 && enemcol3[2] > 0){
            this.fullfield = true;
        }
        else{this.fullfield = false;}
    }

    public void ColAdd(){
        super.ColAdd();
    }

    public void PlaceNum(int dicenum){
        int choice = random.nextInt(3) + 1;
        switch(choice){
            case 1:
                for(int i = 0; i < 3; i++){
                    if(col1[i] == 0){
                        col1[i] = dicenum;
                        this.confirm = true;
                        break;
                    }
                }
                break;
            case 2:
                for(int i = 0; i < 3; i++){
                    if(col2[i] == 0){
                        col2[i] = dicenum;
                        this.confirm = true;
                        break;
                    }
                }
                break;
            case 3:
                for(int i = 0; i < 3; i++){
                    if(col3[i] == 0){
                        col3[i] = dicenum;
                        this.confirm = true;
                        break;
                    }
                }
                break;


        }
    }
}
