abstract class Fighters{
    
    private String name;
    private double health;
    private double mana;
    private double dmg;
    private String type;
    private int SpecialCost;

    public Fighters(String name, double health, double mana, double dmg, String type, int SpecialCost){
        this.name = name;
        this.health = health;
        this.mana = mana;
        this.type = type;
        this.dmg = dmg;
        this.SpecialCost = SpecialCost;
    }

    public String getName(){
        return name;
    }

    public double getHealth(){
        return health;
    }

    public double getMana(){
        return mana;
    }
    public double getDmg(){
        return dmg;
    }

    public String getType(){
        return type;
    }

    public int getSpecialCost(){
        return SpecialCost;
    }

    public void setHealth(double health){
        if(health < 0){
            this.health = 0;
        }else{
            this.health = health;
        }
    }

    public void setMana(double mana){
        if(mana < 0){
            this.mana = 0;
        }else{
            this.mana = mana;
        }
    }

    public void BasicAtt(Fighters target){
        target.setHealth(target.getHealth() - getDmg());
        setMana(getMana() + 10);
    }

    public abstract void SpecialAtt(Fighters target);

}


class FireMage extends Fighters{
    public FireMage(String name){
        super(name, 120, 10, 15, "Fire", 50);
    }

    public void BasicAtt(Fighters target){
        if(target.getType() == "Water"){
            target.setHealth(target.getHealth() - (getDmg() * 2));
            System.out.println(getName() + " used Fire Basic dealing " + getDmg()*2 + " DMG to " + target.getName());
        }
        else if(target.getType() == "Earth"){
            target.setHealth(target.getHealth() - (getDmg() / 2));
            System.out.println(getName() + " used Fire Basic dealing " + getDmg()/2 + " DMG to " + target.getName());
        }else{
            super.BasicAtt(target);
            System.out.println(getName() + " used Fire Basic dealing " + getDmg() + " DMG to " + target.getName());
        }
        setMana(getMana() + 5);
    }

    public void SpecialAtt(Fighters target){
        if(getMana() >= getSpecialCost()){
        System.out.println("Fuga...");
        if(target.getType() == "Water"){
            System.out.println(getName() + " used Fire Arrow on " + target.getName() + " and dealt 50 DMG while decreasing their mana by 30");
            target.setHealth(target.getHealth() - 50);
            target.setMana(target.getMana() - 30);
        }
        else if (target.getType() == "Earth"){
            System.out.println(getName() + " used Fire Arrow on " + target.getName() + " and dealt 12.5 DMG while decreasing their mana by 7.5");
            target.setHealth(target.getHealth() - 12.5);
            target.setMana(target.getMana() - 7.5);
        }
        else{
            System.out.println(getName() + " used Fire Arrow on " + target.getName() + " and dealt 25 DMG while decreasing their mana by 15");
            target.setHealth(target.getHealth() - 25);
            target.setMana(target.getMana() - 15);
        }
        setMana(getMana() - getSpecialCost());
        }
        
    }


}


class WaterMage extends Fighters{
    public WaterMage(String name){
        super(name, 100, 20, 10, "Water", 40);
    }

    public void BasicAtt(Fighters target){
        
        if(target.getType() == "Earth"){
            target.setHealth(target.getHealth() - (getDmg() * 2));
            System.out.println(getName() + " used Water Basic dealing " + getDmg()*2 + " DMG to " + target.getName());
        }
        else if(target.getType() == "Fire"){
            target.setHealth(target.getHealth() - (getDmg() / 2));
            System.out.println(getName() + " used Water Basic dealing " + getDmg()/2 + " DMG to " + target.getName());
        }
        else{
            super.BasicAtt(target);
            System.out.println(getName() + " used Water Basic dealing " + getDmg() + " DMG to " + target.getName());
        }
        setMana(getMana() + 10);
    }

    public void SpecialAtt(Fighters target){
        if(getMana() >= getSpecialCost()){
        System.out.println("Aqua...");
        if(target.getType() == "Earth"){
            target.setHealth(target.getHealth() - 40);
            if(getHealth() <= (100 - 20)){
             setHealth(getHealth() + 20);
            }else{
             setHealth(100);
            }
            System.out.println(getName() + " used Water Ball on " + target.getName() + " and dealt 40 DMG while healing for 20");
        }
        else if(target.getType() == "Fire"){
            target.setHealth(target.getHealth() - 10);
            if(getHealth() <= (100 - 20)){
             setHealth(getHealth() + 20);
            }else{
             setHealth(100);
            }
            System.out.println(getName() + " used Water Ball on " + target.getName() + " and dealt 20 DMG while healing for 20");
        }
        else{
            target.setHealth(target.getHealth() - 20);
            if(getHealth() <= (100 - 20)){
             setHealth(getHealth() + 20);
            }else{
             setHealth(100);
            }
            System.out.println(getName() + " used Water Ball on " + target.getName() + " and dealt 20 DMG while healing for 20");
        }
        
        setMana(getMana() - getSpecialCost());
        }
        
    }


}


class EarthMage extends Fighters{
    public EarthMage(String name){
        super(name, 145, 0, 8, "Earth", 60);
    }

    public void BasicAtt(Fighters target){
        if(target.getType() == "Fire"){
            target.setHealth(target.getHealth() - (getDmg() * 2));
            System.out.println(getName() + " used Earth Basic dealing " + getDmg()*2 + " DMG to " + target.getName());
        }
        else if(target.getType() == "Water"){
            target.setHealth(target.getHealth() - (getDmg() / 2));
            System.out.println(getName() + " used Water Basic dealing " + getDmg()/2 + " DMG to " + target.getName());
        }else{
            super.BasicAtt(target);
            System.out.println(getName() + " used Earth Basic dealing " + getDmg() + " DMG to " + target.getName());
        }
        setMana(getMana() + 15);
    }

    public void SpecialAtt(Fighters target){
        if(getMana() >= getSpecialCost()){
        System.out.println("Kamen vole...");

        if(target.getHealth() < 0.25*target.getHealth()){
            target.setHealth(0);
            System.out.println(getName() + " used Zkurveny Kamen on " + target.getName() + " and fucking killed them");
        }else{

        if(target.getType() == "Fire"){
            target.setHealth(target.getHealth() - 2);
            setHealth(getHealth() + 30);
            System.out.println(getName() + " used Zkurveny Kamen on " + target.getName() + " and dealt 2 DMG while increasing HP by 30");
        }
        else if(target.getType() == "Water"){
            target.setHealth(target.getHealth() - 0.5);
            setHealth(getHealth() + 30);
            System.out.println(getName() + " used Zkurveny Kamen on " + target.getName() + " and dealt 0.5 DMG while increasing HP by 30");
        }
        else{
            target.setHealth(target.getHealth() - 1);
            setHealth(getHealth() + 30);
            System.out.println(getName() + " used Zkurveny Kamen on " + target.getName() + " and dealt 1 DMG while increasing HP by 30");
        }

        }

        
        setMana(getMana() - getSpecialCost());
        }
        
    }


}


