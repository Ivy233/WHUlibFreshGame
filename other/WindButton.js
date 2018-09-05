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
        // foo: {
        //     // ATTRIBUTES:
        //     default: null,        // The default value will be used only when the component attaching
        //                           // to a node for the first time
        //     type: cc.SpriteFrame, // optional, default is typeof default
        //     serializable: true,   // optional, default is true
        // },
        // bar: {
        //     get () {
        //         return this._bar;
        //     },
        //     set (value) {
        //         this._bar = value;
        //     }
		// },
		
		first_view:{
            default:null,
            type:cc.Node
		},
		first_word:{
			default:null,
			type:cc.Label
		},
		last_word:{
			default:null,
			type:cc.Label
		},
		failure_word:{
			default:null,
			type:cc.Label
		},
		failure:{
            default:null,
            type:cc.Node
        },
        success:{
            default:null,
            type:cc.Node
		},
		one:{
			default:null,
            type:cc.Node
		},
		two:{
			default:null,
            type:cc.Node
		},
		mubu_left:{
			default:null,
            type:cc.Node
		},
		mubu_right:{
			default:null,
            type:cc.Node
		},
		userlogo:{
			default:null,
            type:cc.Node
		},
    },

    // LIFE-CYCLE CALLBACKS:

	onLoad:function(){
		//this.first_view.runAction( cc.moveBy(0.3, cc.p(0, -500)).easing(cc.easeCubicActionIn()))
		//this.two.active = false
		//this.failure.active = false
		//this.success.active = false
		//cc.find("first_view").runAction(cc.moveBy(0.3, cc.p(0, -120)).easing(cc.easeCubicActionIn()))
		var R = Math.random()
		cc.log(R)
		if(R<0.25){
			this.changelogo("素材/a1.png")
		}
		else if(R<0.5){
			this.changelogo("素材/a2.png")
		}
		else if(R<0.75){
			this.changelogo("素材/a3.png")
		}
		else{
			this.changelogo("素材/a4.png")
		}
		
		cc.find("Canvas/failure_board").active = false
		cc.find("Canvas/success_board").active = false
		cc.find("Canvas/first_view").runAction(cc.moveBy(0.6, cc.p(0, -250)).easing(cc.easeCubicActionIn()))
		cc.find("Canvas/mubu_left").runAction(cc.moveBy(0.3, cc.p(250, 0)).easing(cc.easeCubicActionIn()))
		cc.find("Canvas/mubu_right").runAction(cc.moveBy(0.3, cc.p(-250, 0)).easing(cc.easeCubicActionIn()))
	},
	changelogo:function(url){
		// var realurl = cc.url.raw(url)
		// var cache = cc.textureCache.addImage(realurl)
		//cc.find("Canvas/userlogo").getComponent(cc.Sprite).spriteFrame.setTexture(cache)
		cc.log(url)
		 cc.loader.loadRes(url, cc.SpriteFrame, function (err, spriteFrame) {
			cc.find("Canvas/userlogo").getComponent(cc.Sprite).spriteFrame = spriteFrame
		 });
	},
	fadeOut:function()
	{
		this.one.active = true
		this.two.active = false
		var strA = "Canvas/answerA";
		var strB = "Canvas/answerB";
		var strC = "Canvas/answerC";
		var strD = "Canvas/answerD";
		var AnswerA = cc.find(strA);
		var AnswerB = cc.find(strB);
		var AnswerC = cc.find(strC);
		var AnswerD = cc.find(strD);
		AnswerA.opacity = 255;
		AnswerA.color = cc.color(255,255,255,255);
		AnswerB.opacity = 255;
		AnswerB.color = cc.color(255,255,255,255);
		AnswerC.opacity = 255;
		AnswerC.color = cc.color(255,255,255,255);
		AnswerD.opacity = 255;
		AnswerD.color = cc.color(255,255,255,255);
	},
	change:function()
	{
		var node = cc.find("Canvas/userInfor/clock_time")
		this.schedule(this.ClockUpdate, 1, 119);
		this.fadeOut();
		if(Global.scene==1)
		{
			if(Global.num_error>0)
			{
				this.unschedule(this.ClockUpdate)
				cc.find("Canvas/failure_board").active = true
				
			}
			else if(Global.num_process1<=17)
			{
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
				
				var question = cc.find("Canvas/question").getComponent(cc.Label);
				var answerA = cc.find("Canvas/answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = cc.find("Canvas/answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = cc.find("Canvas/answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = cc.find("Canvas/answerD").getChildByName("Label").getComponent(cc.Label);
				
				jindutiao.x = Global.num_process1*160/18-70;
				progress.string = Global.num_process1+"/18";
				question.string = Global.num_process1+"."+Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					cc.find("Canvas/answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					cc.find("Canvas/answerA").active = false;

				if (Global.toB[Global.now] != "") {
					cc.find("Canvas/answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					cc.find("Canvas/answerB").active = false;
				if (Global.toC[Global.now] != "") {
					cc.find("Canvas/answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					cc.find("Canvas/answerC").active = false;
				if (Global.toD[Global.now] != "") {
					cc.find("Canvas/answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					cc.find("Canvas/answerD").active = false;
			}
			else
			{
				Global.num_error=0;
				this.unschedule(this.ClockUpdate)
				//cc.director.loadScene("WindSuccess");
				cc.find("Canvas/success_board").active = true
				cc.loader.loadRes("素材/shuijin.png", cc.SpriteFrame, function (err, spriteFrame) {
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).normalSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).pressedSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				cc.find("Canvas/success_board/two/thing_name").getComponent(cc.Label).string =  "精灵的水晶"
				cc.find("Canvas/success_board/two/point").getComponent(cc.Label).string =  Global.points1
				cc.find("Canvas/success_board/two/time").getComponent(cc.Label).string =  Global.time[1]
			}
		}
		else if(Global.scene==2)
		{
			if(Global.num_error>8)
			{
				this.unschedule(this.ClockUpdate)
				//cc.director.loadScene("WindFailure");
				cc.find("Canvas/failure_board").active = true
			}
			else if(Global.num_process2<=12)
			{
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
				cc.loader.loadRes("素材/鲲鹏广场.png", cc.SpriteFrame, function (err, spriteFrame) {
					cc.find("Canvas/background1").getComponent(cc.Sprite).spriteFrame = spriteFrame
				});
				// cc.loader.loadRes("素材/sprite.png", cc.SpriteFrame, function (err, spriteFrame) {
				// 	node.getComponent(cc.Button).normalSprite = spriteFrame;
				// 	node.getComponent(cc.Button).pressedSprite = spriteFrame;
				// 	node.getComponent(cc.Button).hoverSprite = spriteFrame;
				// });
				Global.num_process2++;
				Global.now = Global.index2[Global.num_process2-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				
				var question = cc.find("Canvas/question").getComponent(cc.Label);
				var answerA = cc.find("Canvas/answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = cc.find("Canvas/answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = cc.find("Canvas/answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = cc.find("Canvas/answerD").getChildByName("Label").getComponent(cc.Label);
				
				jindutiao.x = Global.num_process2*160/13-70;
				progress.string = Global.num_process2+"/13";
				question.string = Global.num_process2+"."+Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					cc.find("Canvas/answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					cc.find("Canvas/answerA").active = false;

				if (Global.toB[Global.now] != "") {
					cc.find("Canvas/answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					cc.find("Canvas/answerB").active = false;
				if (Global.toC[Global.now] != "") {
					cc.find("Canvas/answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					cc.find("Canvas/answerC").active = false;
				if (Global.toD[Global.now] != "") {
					cc.find("Canvas/answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					cc.find("Canvas/answerD").active = false;
			}
			else
			{
				Global.num_error=0;
				this.unschedule(this.ClockUpdate)
				//cc.director.loadScene("WindSuccess");
				cc.find("Canvas/success_board").active = true
				cc.loader.loadRes("素材/yumao.png", cc.SpriteFrame, function (err, spriteFrame) {
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).normalSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).pressedSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				cc.find("Canvas/success_board/two/thing_name").getComponent(cc.Label).string =  "大鹏的羽毛"
				cc.find("Canvas/success_board/two/point").getComponent(cc.Label).string =  Global.points2
				cc.find("Canvas/success_board/two/time").getComponent(cc.Label).string =  Global.time[2]
			}
		}
		else if(Global.scene==3)
		{
			if(Global.num_error>=10)
			{
				this.unschedule(this.ClockUpdate)
				//cc.director.loadScene("WindFailure");
				cc.find("Canvas/failure_board").active = true
			}
			else if(Global.num_process3<=15)
			{
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
				cc.loader.loadRes("素材/东湖.png", cc.SpriteFrame, function (err, spriteFrame) {
					cc.find("Canvas/background1").getComponent(cc.Sprite).spriteFrame = spriteFrame
				});
				Global.num_process3++;
				Global.now = Global.index3[Global.num_process3-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				
				var question = cc.find("Canvas/question").getComponent(cc.Label);
				var answerA = cc.find("Canvas/answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = cc.find("Canvas/answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = cc.find("Canvas/answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = cc.find("Canvas/answerD").getChildByName("Label").getComponent(cc.Label);
				
				progress.string = Global.num_process3+"/16";
				question.string = Global.num_process3+"."+Global.question[Global.now];
				jindutiao.x = Global.num_process3*160/16-70;
				if (Global.toA[Global.now] != "") {
					cc.find("Canvas/answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					cc.find("Canvas/answerA").active = false;

				if (Global.toB[Global.now] != "") {
					cc.find("Canvas/answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					cc.find("Canvas/answerB").active = false;
				if (Global.toC[Global.now] != "") {
					cc.find("Canvas/answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					cc.find("Canvas/answerC").active = false;
				if (Global.toD[Global.now] != "") {
					cc.find("Canvas/answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					cc.find("Canvas/answerD").active = false;
			}
			else
			{
				Global.num_error=0;
				this.unschedule(this.ClockUpdate)
				//cc.director.loadScene("WindSuccess");
				cc.find("Canvas/success_board").active = true
				cc.loader.loadRes("素材/lingjia.png", cc.SpriteFrame, function (err, spriteFrame) {
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).normalSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).pressedSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				cc.find("Canvas/success_board/two/thing_name").getComponent(cc.Label).string =  "龙王的鳞甲"
				cc.find("Canvas/success_board/two/point").getComponent(cc.Label).string =  Global.points3
				cc.find("Canvas/success_board/two/time").getComponent(cc.Label).string =  Global.time[3]
			}
		}
		if(Global.scene==4)
		{
			if(Global.num_error>2)
			{
				this.unschedule(this.ClockUpdate)
				//cc.director.loadScene("WindFailure");
				cc.find("Canvas/failure_board").active = true
			}
			else if(Global.num_process4<=2)//我把这里当做每一关的开始
			{
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
				cc.loader.loadRes("素材/珞珈山.png", cc.SpriteFrame, function (err, spriteFrame) {
					cc.find("Canvas/background1").getComponent(cc.Sprite).spriteFrame = spriteFrame
				});
				Global.num_process4++;
				Global.now = Global.index4[Global.num_process4-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				
				var question = cc.find("Canvas/question").getComponent(cc.Label);
				var answerA = cc.find("Canvas/answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = cc.find("Canvas/answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = cc.find("Canvas/answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = cc.find("Canvas/answerD").getChildByName("Label").getComponent(cc.Label);
				
				jindutiao.x = Global.num_process4*160/3-70;
				progress.string = Global.num_process4+"/3";
				question.string = Global.num_process4+"."+Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					cc.find("Canvas/answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					cc.find("Canvas/answerA").active = false;

				if (Global.toB[Global.now] != "") {
					cc.find("Canvas/answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					cc.find("Canvas/answerB").active = false;
				if (Global.toC[Global.now] != "") {
					cc.find("Canvas/answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					cc.find("Canvas/answerC").active = false;
				if (Global.toD[Global.now] != "") {
					cc.find("Canvas/answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					cc.find("Canvas/answerD").active = false;
			}
			else
			{
				Global.num_error=0;
				this.unschedule(this.ClockUpdate)
				//cc.director.loadScene("WindSuccess");
				cc.find("Canvas/success_board").active = true
				cc.loader.loadRes("素材/neidan.png", cc.SpriteFrame, function (err, spriteFrame) {
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).normalSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).pressedSprite = spriteFrame;
					cc.find("Canvas/success_board/two/thing").getComponent(cc.Button).hoverSprite = spriteFrame;
				});
				cc.find("Canvas/success_board/two/thing_name").getComponent(cc.Label).string =  "珞珞的内丹"
				cc.find("Canvas/success_board/two/point").getComponent(cc.Label).string =  Global.points4
				cc.find("Canvas/success_board/two/time").getComponent(cc.Label).string =  Global.time[4]
			}
		}
		if(Global.scene==0)
		{
			
			if(Global.num_error>0||Global.time[Global.scene]>120)
			{
				this.unschedule(this.ClockUpdate)
				cc.director.loadScene("Challenge");
			}
			else if(true)
			{

				Global.num_process5++;
				Global.now = Global.index5[Global.num_process5-1];
				var progress = cc.find("Canvas/userInfor/process_num").getComponent(cc.Label);
				var question = cc.find("Canvas/question").getComponent(cc.Label);
				var answerA = cc.find("Canvas/answerA").getChildByName("Label").getComponent(cc.Label);
				var answerB = cc.find("Canvas/answerB").getChildByName("Label").getComponent(cc.Label);
				var answerC = cc.find("Canvas/answerC").getChildByName("Label").getComponent(cc.Label);
				var answerD = cc.find("Canvas/answerD").getChildByName("Label").getComponent(cc.Label);
				progress.string = Global.num_process5;
				question.string = Global.question[Global.now];
				if (Global.toA[Global.now] != "") {
					cc.find("Canvas/answerA").active = true;
					answerA.string = "  " + Global.toA[Global.now];
				}
				else
					cc.find("Canvas/answerA").active = false;

				if (Global.toB[Global.now] != "") {
					cc.find("Canvas/answerB").active = true;
					answerB.string = "  " + Global.toB[Global.now];
				}
				else
					cc.find("Canvas/answerB").active = false;
				if (Global.toC[Global.now] != "") {
					cc.find("Canvas/answerC").active = true;
					answerC.string = "  " + Global.toC[Global.now];
				}
				else
					cc.find("Canvas/answerC").active = false;
				if (Global.toD[Global.now] != "") {
					cc.find("Canvas/answerD").active = true;
					answerD.string = "  " + Global.toD[Global.now];
				}
				else
					cc.find("Canvas/answerD").active = false;
			}
		}
	},
	fadeAway:function()
	{
		var strA = "Canvas/answerA";
		var strB = "Canvas/answerB";
		var strC = "Canvas/answerC";
		var strD = "Canvas/answerD";
		var AnswerA = cc.find(strA);
		var AnswerB = cc.find(strB);
		var AnswerC = cc.find(strC);
		var AnswerD = cc.find(strD);
		AnswerA.opacity = 0;
		AnswerB.opacity = 0;
		AnswerC.opacity = 0;
		AnswerD.opacity = 0;
	},
	showRight:function()
	{
		var str = "Canvas/answer"+Global.right[Global.now];
		var RAnswer = cc.find(str);
		RAnswer.color = cc.color(0,255,0,255);
		RAnswer.opacity = 255;
	},
	showError:function()
	{
		this.node.color = cc.color(255,0,0,255);
		this.node.opacity = 255;
		Global.num_error++;
	},
	A:function()
	{
		cc.find("Canvas/userInfor/clock_time").opacity=254;
		this.fadeAway();
		if(Global.right[Global.now]!="A")
		{
			Global.record[Global.now]=0;
			this.showError();
		}
		else
		{
			Global.record[Global.now]=1;
			if(Global.scene==1)
			{
				Global.points1+=2;
			}
			if(Global.scene==2)
			{
				Global.points2+=2;
			}
			if(Global.scene==3)
			{
				Global.points3+=2;
			}
			if(Global.scene==4)
			{
				Global.points4+=2;
			}
			if(Global.scene==0)
			{
				Global.points5+=2;
			}
		}
		this.showRight();
		var node = cc.find("Canvas/userInfor/clock_time")
		var component = node.getComponent(cc.Label);
		component.string = 120;
		this.unschedule(this.ClockUpdate)
		this.scheduleOnce(this.change,2);
		
	},
	B:function()
	{
		cc.find("Canvas/userInfor/clock_time").opacity=254;
		this.fadeAway();
		if(Global.right[Global.now]!="B")
		{
			Global.record[Global.now]=0;
			this.showError();
		}
		else
		{
			Global.record[Global.now]=1;
			if(Global.scene==1)
			{
				Global.points1+=2;
			}
			if(Global.scene==2)
			{
				Global.points2+=2;
			}
			if(Global.scene==3)
			{
				Global.points3+=2;
			}
			if(Global.scene==4)
			{
				Global.points4+=2;
			}
			if(Global.scene==0)
			{
				Global.points5+=2;
			}
		}
		this.showRight();
		var node = cc.find("Canvas/userInfor/clock_time")
		var component = node.getComponent(cc.Label);
		component.string = 120;
		this.unschedule(this.ClockUpdate)
		this.scheduleOnce(this.change,2);
	},
	C:function()
	{
		cc.find("Canvas/userInfor/clock_time").opacity=254;
		this.fadeAway();
		if(Global.right[Global.now]!="C")
		{
			Global.record[Global.now]=0;
			this.showError();
		}
		else
		{
			Global.record[Global.now]=1;
			if(Global.scene==1)
			{
				Global.points1+=2;
			}
			if(Global.scene==2)
			{
				Global.points2+=2;
			}
			if(Global.scene==3)
			{
				Global.points3+=2;
			}
			if(Global.scene==4)
			{
				Global.points4+=2;
			}
			if(Global.scene==0)
			{
				Global.points5+=2;
			}
		}
		this.showRight();
		var node = cc.find("Canvas/userInfor/clock_time")
		var component = node.getComponent(cc.Label);
		component.string = 120;
		this.unschedule(this.ClockUpdate)
		this.scheduleOnce(this.change,2);
	},
	D:function()
	{
		cc.find("Canvas/userInfor/clock_time").opacity=254;  
		this.fadeAway();
		if(Global.right[Global.now]!="D")
		{
			Global.record[Global.now]=0;
			this.showError();
		}
		else
		{
			Global.record[Global.now]=1;
			if(Global.scene==1)
			{
				Global.points1+=2;
			}
			if(Global.scene==2)
			{
				Global.points2+=2;
			}
			if(Global.scene==3)
			{
				Global.points3+=2;
			}
			if(Global.scene==4)
			{
				Global.points4+=2;
			}
			if(Global.scene==0)
			{
				Global.points5+=2;
			}
		}
		this.showRight();
		var node = cc.find("Canvas/userInfor/clock_time")
		var component = node.getComponent(cc.Label);
		component.string = 120;
		this.unschedule(this.ClockUpdate)
		this.scheduleOnce(this.change,2);
	},
	
	next:function()
	{
		
		if(Global.scene==1)
		{
			this.mubu_left.runAction(cc.moveBy(0.3, cc.p(500, 0)).easing(cc.easeCubicActionIn()))
			this.mubu_right.runAction(cc.moveBy(0.3, cc.p(-500, 0)).easing(cc.easeCubicActionIn()))
			Global.scene++;
			this.first_word.string = "鲲鹏广场上有一只大鹏，\n它有一些关于图书馆的疑惑，\n只要你帮它解答问题，\n就能得到关于小布的线索哦。"
			this.last_word.string = "恭恭喜你得到大鹏的感激，\n它送给你一根神奇的羽毛，\n可以帮你找到小布。"
			this.failure_word.string = "很遗憾，\n大鹏对你的解答很不满意，\n它回鲲鹏广场去啦！"
		}
		else if(Global.scene==2)
		{
			this.mubu_left.runAction(cc.moveBy(0.3, cc.p(500, 0)).easing(cc.easeCubicActionIn()))
			this.mubu_right.runAction(cc.moveBy(0.3, cc.p(-500, 0)).easing(cc.easeCubicActionIn()))
			Global.scene++;
			this.first_word.string = "东湖上空经常盘旋着一条龙，\n它是东湖的守护龙神。\n只要你帮它解答问题，\n就能得到关于小布的线索。"
			this.last_word.string = "恭喜你得到龙王的信任，\n它送给你一根神奇的鳞甲，\n可以帮你找到小布。"
			this.failure_word.string = "很遗憾，\n龙王对你的解答很不满意，\n它回东湖去啦！"
		}
		else if(Global.scene==3)
		{
			this.mubu_left.runAction(cc.moveBy(0.3, cc.p(500, 0)).easing(cc.easeCubicActionIn()))
			this.mubu_right.runAction(cc.moveBy(0.3, cc.p(-500, 0)).easing(cc.easeCubicActionIn()))
			Global.scene++;
			this.first_word.string = "珞珈山上有一只爱读书的狐狸珞珞。\n只要你帮它解答问题，\n就能得到关于小布的线索。"
			this.last_word.string = "恭喜你得到狐狸的喜爱，\n它送给你一根神奇的内丹，\n可以帮你找到小布。"
			this.failure_word.string = "很遗憾，\n珞珞对你的解答很不满意，\n它回珞珈山去啦！"
		}
		else if(Global.scene==4)
		{
			Global.scene++;
			Global.points = Global.points1+Global.points2+Global.points3+Global.points4;
			cc.director.loadScene("Success")
		}
		var node = cc.find("Canvas/userInfor/clock_time")
		var component = node.getComponent(cc.Label);
		component.string = 120;
		this.unschedule(this.ClockUpdate)
		this.scheduleOnce(this.change,0.3)
		//this.change();
		this.first_view.runAction( cc.moveBy(0.6, cc.p(0, -500)).easing(cc.easeCubicActionIn()))
		this.success.active = false
		this.failure.active = false
		this.one.active = true
		this.two.active = false
	},
	
	again:function()
	{
		this.mubu_left.runAction(cc.moveBy(0.3, cc.p(500, 0)).easing(cc.easeCubicActionIn()))
		this.mubu_right.runAction(cc.moveBy(0.3, cc.p(-500, 0)).easing(cc.easeCubicActionIn()))
		if(Global.scene==1)
		{
			Global.points1=0;
			Global.num_process1=0;
			Global.scene=1;
			Global.time[1]=0;
		}
		if(Global.scene==2)
		{
			Global.points2=0;
			Global.num_process2=0;
			Global.scene=2;
			Global.time[2]=0;
		}
		if(Global.scene==3)
		{
			Global.points3=0;
			Global.num_process3=0;
			Global.scene=3;
			Global.time[3]=0;
		}
		if(Global.scene==4)
		{
			Global.points4=0;
			Global.num_process4=0;
			Global.scene=4;
			Global.time[4]=0;
		}
		Global.num_error=0
		var node = cc.find("Canvas/userInfor/clock_time")
		var component = node.getComponent(cc.Label);
		component.string = 120;
		this.unschedule(this.ClockUpdate)
		
		this.success.active = false
		this.failure.active = false
		this.one.active = true
		this.two.active = false
		this.scheduleOnce(this.change,0.3)
		//this.change();
		this.first_view.runAction( cc.moveBy(0.6, cc.p(0, -500)).easing(cc.easeCubicActionIn()))
		//this.first_view.runAction( cc.moveBy(0.3, cc.p(0, -500)).easing(cc.easeCubicActionIn()))
		//cc.director.loadScene("Welcome")
	},
	
	back:function()
	{
		cc.director.loadScene("begin");
	},
	
	click:function(){
		var node = cc.find("Canvas/userInfor/clock_time")
		var component = node.getComponent(cc.Label);
		component.string = 120;
		this.schedule(this.ClockUpdate, 1, 119);
		this.first_view.runAction( cc.moveBy(0.3, cc.p(0, 500)).easing(cc.easeCubicActionIn()))
		this.mubu_left.runAction(cc.moveBy(0.3, cc.p(-500, 0)).easing(cc.easeCubicActionIn()))
		this.mubu_right.runAction(cc.moveBy(0.3, cc.p(500, 0)).easing(cc.easeCubicActionIn()))
	},
	goon:function(){
		this.one.active = false
		this.two.active = true
	},
    update:function(dt) 
	{
		var node=cc.find("Canvas/userInfor/clock_time");
		var label = node.getComponent(cc.Label);
		if(label.string<=0)
		{
			this.fadeAway();
			this.showRight();
			Global.num_error1++;
			this.scheduleOnce(this.load,2);
		}
		//cc.log(Global.time[0])
	},
	ClockUpdate: function (){
		Global.time[Global.scene]++;
		var node = cc.find("Canvas/userInfor/clock_time")
        var component = node.getComponent(cc.Label);
		component.string = component.string - 1;
    },
});
