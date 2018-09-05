// Learn cc.Class:
//  - [Chinese] http://docs.cocos.com/creator/manual/zh/scripting/class.html
//  - [English] http://www.cocos2d-x.org/docs/creator/en/scripting/class.html
// Learn Attribute:
//  - [Chinese] http://docs.cocos.com/creator/manual/zh/scripting/reference/attributes.html
//  - [English] http://www.cocos2d-x.org/docs/creator/en/scripting/reference/attributes.html
// Learn life-cycle callbacks:
//  - [Chinese] http://docs.cocos.com/creator/manual/zh/scripting/life-cycle-callbacks.html
//  - [English] http://www.cocos2d-x.org/docs/creator/en/scripting/life-cycle-callbacks.html

cc.Class({
    extends: cc.Component,

    properties: {
		
    },

    // LIFE-CYCLE CALLBACKS:
	
	start:function () 
    {
		console.log("123")
		
		if(Global.scene==1)
		{
			if(Global.num_error>0)
			{
				//cc.director.loadScene("WindFailure");
				//this.failure.active = true
			}
			else if(Global.num_process1<=17)
			{
				
				var NPC_IMG = cc.find("Canvas/NPC_IMG")
				NPC_IMG.active=true;
				var NPC_border = cc.find("Canvas/NPC_border")
				NPC_border.active=true;
				var jindutiao = cc.find("Canvas/userInfor/jindutiao");
				var NPC = cc.find("Canvas/NPC").getComponent(cc.Label);
				
				var node = cc.find("Canvas/NPC_IMG");
				node.x=-160;
				node.y=-40;
				node.width=480;
				node.height=540;
				cc.loader.loadRes("素材/sprite.png", cc.SpriteFrame, function (err, spriteFrame) {
					node.getComponent(cc.Button).normalSprite = spriteFrame;
					node.getComponent(cc.Button).pressedSprite = spriteFrame;
					node.getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				
				NPC.string = "精灵图图";
				Global.num_process1++;
				Global.now = Global.index1[Global.num_process1-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				var question = this.node.getChildByName("question").getComponent(cc.Label);
				var answerA = this.node.getChildByName("answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = this.node.getChildByName("answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = this.node.getChildByName("answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = this.node.getChildByName("answerD").getChildByName("Label").getComponent(cc.Label);
				jindutiao.x = Global.num_process1*160/18-70;
				progress.string = Global.num_process1+"/18";
				question.string = Global.num_process1+"."+Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					this.node.getChildByName("answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					this.node.getChildByName("answerA").active = false;

				if (Global.toB[Global.now] != "") {
					this.node.getChildByName("answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					this.node.getChildByName("answerB").active = false;
				if (Global.toC[Global.now] != "") {
					this.node.getChildByName("answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					this.node.getChildByName("answerC").active = false;
				if (Global.toD[Global.now] != "") {
					this.node.getChildByName("answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					this.node.getChildByName("answerD").active = false;
			}
			else
			{
				//cc.director.loadScene("WindSuccess");
				//this.success.active = true
			}
		}
		else if(Global.scene==2)
		{
			if(Global.num_error>8)
			{
				//cc.director.loadScene("WindFailure");
				//this.failure.active = true
			}
			else if(Global.num_process2<=12)
			{
				var NPC_IMG = cc.find("Canvas/NPC_IMG")
				NPC_IMG.active=true;
				var NPC_border = cc.find("Canvas/NPC_border")
				NPC_border.active=true;
				this.first_word = "鲲鹏广场上有一只大鹏，\n它有一些关于图书馆的疑惑，\n只要你帮它解答问题，\n就能得到关于小布的线索哦。"
				this.last_word = "恭喜你得到大鹏的感激，\n它送给你一根神奇的羽毛，\n可以帮你找到小布。"
				this.failure_word.string = "很遗憾，大鹏对你的解答很不满意，\n它回鲲鹏广场去啦！"
				var jindutiao = cc.find("Canvas/userInfor/jindutiao");
				var NPC = cc.find("Canvas/NPC").getComponent(cc.Label);
				NPC.string = "大鹏鸟";
				
				var node = cc.find("Canvas/NPC_IMG");
				node.x=-160;
				node.y=0;
				node.width=480;
				node.height=480;
				cc.loader.loadRes("素材/bird2.png", cc.SpriteFrame, function (err, spriteFrame) {
					node.getComponent(cc.Button).normalSprite = spriteFrame;
					node.getComponent(cc.Button).pressedSprite = spriteFrame;
					node.getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				
				Global.num_process2++;
				Global.now = Global.index2[Global.num_process2-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				var question = this.node.getChildByName("question").getComponent(cc.Label);
				var answerA = this.node.getChildByName("answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = this.node.getChildByName("answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = this.node.getChildByName("answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = this.node.getChildByName("answerD").getChildByName("Label").getComponent(cc.Label);
				jindutiao.x = Global.num_process2*160/13-70;
				progress.string = Global.num_process2+"/13";
				question.string = Global.num_process2+"."+Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					this.node.getChildByName("answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					this.node.getChildByName("answerA").active = false;

				if (Global.toB[Global.now] != "") {
					this.node.getChildByName("answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					this.node.getChildByName("answerB").active = false;
				if (Global.toC[Global.now] != "") {
					this.node.getChildByName("answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					this.node.getChildByName("answerC").active = false;
				if (Global.toD[Global.now] != "") {
					this.node.getChildByName("answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					this.node.getChildByName("answerD").active = false;
			}
			else
			{
				//cc.director.loadScene("WindSuccess");
				//this.success.active = true
			}
		}
		else if(Global.scene==3)
		{
			if(Global.num_error>7)
			{
				//cc.director.loadScene("WindFailure");
				//this.failure.active = true
			}
			else if(Global.num_process3<=15)
			{
				var NPC_IMG = cc.find("Canvas/NPC_IMG")
				NPC_IMG.active=true;
				var NPC_border = cc.find("Canvas/NPC_border")
				NPC_border.active=true;
				this.first_word = "东湖上空经常盘旋着一条龙，\n它是东湖的守护龙神。\n只要你帮它解答问题，\n就能得到关于小布的线索。"
				this.last_word = "恭喜你得到龙王的信任，\n它送给你一根神奇的鳞甲，\n可以帮你找到小布。"
				this.failure_word.string = "很遗憾，龙王对你的解答很不满意，\n它回东湖去啦！"
				var jindutiao = cc.find("Canvas/userInfor/jindutiao");
				var NPC = cc.find("Canvas/NPC").getComponent(cc.Label);
				NPC.string = "东湖龙王";
				
				var node = cc.find("Canvas/NPC_IMG");
				node.x=-120;
				node.y=0;
				node.width=480;
				node.height=480;
				cc.loader.loadRes("素材/dragon.png", cc.SpriteFrame, function (err, spriteFrame) {
					node.getComponent(cc.Button).normalSprite = spriteFrame;
					node.getComponent(cc.Button).pressedSprite = spriteFrame;
					node.getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				
				Global.num_process3++;
				Global.now = Global.index3[Global.num_process3-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				var question = this.node.getChildByName("question").getComponent(cc.Label);
				var answerA = this.node.getChildByName("answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = this.node.getChildByName("answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = this.node.getChildByName("answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = this.node.getChildByName("answerD").getChildByName("Label").getComponent(cc.Label);
				progress.string = Global.num_process3+"/16";
				question.string = Global.num_process3+"."+Global.question[Global.now];
				jindutiao.x = Global.num_process3*160/16-70;
				if (Global.toA[Global.now] != "") {
					this.node.getChildByName("answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					this.node.getChildByName("answerA").active = false;

				if (Global.toB[Global.now] != "") {
					this.node.getChildByName("answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					this.node.getChildByName("answerB").active = false;
				if (Global.toC[Global.now] != "") {
					this.node.getChildByName("answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					this.node.getChildByName("answerC").active = false;
				if (Global.toD[Global.now] != "") {
					this.node.getChildByName("answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					this.node.getChildByName("answerD").active = false;
			}
			else
			{
				//cc.director.loadScene("WindSuccess");
				//this.success.active = true
			}
		}
		if(Global.scene==4)
		{
			if(Global.num_error>2)
			{
				//cc.director.loadScene("WindFailure");
				//this.failure.active = true
			}
			else if(Global.num_process4<=2)
			{
				var NPC_IMG = cc.find("Canvas/NPC_IMG")
				NPC_IMG.active=true;
				var NPC_border = cc.find("Canvas/NPC_border")
				NPC_border.active=true;
				this.first_word = "珞珈山上有一只爱读书的狐狸珞珞。\n只要你帮它解答问题，\n就能得到关于小布的线索。"
				this.last_word = "恭喜你得到狐狸的喜爱，\n它送给你一根神奇的内丹，\n可以帮你找到小布。"
				this.failure_word.string = "很遗憾，珞珞对你的解答很不满意，\n它回珞珈山去啦！"
				var jindutiao = cc.find("Canvas/userInfor/jindutiao");
				var NPC = cc.find("Canvas/NPC").getComponent(cc.Label);
				NPC.string = "狐狸珞珞";
				
				var node = cc.find("Canvas/NPC_IMG");
				node.x=-230;
				node.y=0;
				node.width=500;
				node.height=500;
				cc.loader.loadRes("素材/fox.png", cc.SpriteFrame, function (err, spriteFrame) {
					node.getComponent(cc.Button).normalSprite = spriteFrame;
					node.getComponent(cc.Button).pressedSprite = spriteFrame;
					node.getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				
				Global.num_process4++;
				Global.now = Global.index4[Global.num_process4-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				var question = this.node.getChildByName("question").getComponent(cc.Label);
				var answerA = this.node.getChildByName("answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = this.node.getChildByName("answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = this.node.getChildByName("answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = this.node.getChildByName("answerD").getChildByName("Label").getComponent(cc.Label);
				jindutiao.x = Global.num_process4*160/3-70;
				progress.string = Global.num_process4+"/3";
				question.string = Global.num_process4+"."+Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					this.node.getChildByName("answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					this.node.getChildByName("answerA").active = false;

				if (Global.toB[Global.now] != "") {
					this.node.getChildByName("answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					this.node.getChildByName("answerB").active = false;
				if (Global.toC[Global.now] != "") {
					this.node.getChildByName("answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					this.node.getChildByName("answerC").active = false;
				if (Global.toD[Global.now] != "") {
					this.node.getChildByName("answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					this.node.getChildByName("answerD").active = false;
			}
			else
			{
				//cc.director.loadScene("WindSuccess");
				//this.success.active = true
			}
		}
		if(Global.scene==0)
		{
			
			if(Global.num_error>0||Global.time[Global.scene]>120)
			{
				cc.director.loadScene("Challenge");
			}
			else if(true)
			{
				var welcome = cc.find("Canvas/first_view/first_word").getComponent(cc.Label);
				welcome.string = "欢迎来到挑战关卡\n你能在两分钟内答对多少题呢？\n"
				var NPC_IMG = cc.find("Canvas/NPC_IMG")
				NPC_IMG.active=false;
				var NPC_border = cc.find("Canvas/NPC_border")
				NPC_border.active=false;
				Global.num_process5++;
				Global.now = Global.index5[Global.num_process5-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				var question = this.node.getChildByName("question").getComponent(cc.Label);
				var answerA = this.node.getChildByName("answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = this.node.getChildByName("answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = this.node.getChildByName("answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = this.node.getChildByName("answerD").getChildByName("Label").getComponent(cc.Label);
				progress.string = Global.num_process5;
				question.string = Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					this.node.getChildByName("answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					this.node.getChildByName("answerA").active = false;

				if (Global.toB[Global.now] != "") {
					this.node.getChildByName("answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					this.node.getChildByName("answerB").active = false;
				if (Global.toC[Global.now] != "") {
					this.node.getChildByName("answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					this.node.getChildByName("answerC").active = false;
				if (Global.toD[Global.now] != "") {
					this.node.getChildByName("answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					this.node.getChildByName("answerD").active = false;
			}
		}
    },
	ClockUpdate: function (){
		Global.time[Global.scene]++;
		var node = cc.find("Canvas/userInfor/clock_time")
        var component = node.getComponent(cc.Label);
			component.string = component.string - 1;
    },

	
    // update (dt) {},
});
