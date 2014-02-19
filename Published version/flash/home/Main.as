/*
Organization:

Layers:
-Background
-Buttons
-Cover

Description:
Frame: A single slide that can be moved
Buttons: Navigation buttons
Cover: An image ontop of everthing else

Directions:
"Random" - random direction
"Left" - moves everything to the left
"Right" - moves everything to the right
"Up" - moves everything up
"Down" - moves everything down

*/
package {
	import flash.display.MovieClip;
	import flash.events.Event;
	public class Main extends MovieClip {
		private var cover:Cover = new Cover();
		private var coverLayer:MovieClip = new MovieClip();
		
		public var buttons:Array = new Array();
		private const buttonSize:Array = new Array(25,25);
		private var buttonMCs:Array = new Array();
		private var buttonLayer:MovieClip = new MovieClip();
		
		private var backgroundLayer:Bgs = new Bgs();
		
		private var timerDelay:uint = 8;//seconds
		private var timer:uint = 0;
		
		private const startFrame:uint = 0;
		
		private var currFrame:uint = startFrame;
		private var previousFrame:uint = startFrame;
		
		public function Main():void {
			this.cacheAsBitmap = true;
			addButtonPlaces();
			addItems();
			addEventListener(Event.ADDED_TO_STAGE,onAdd);
			addEventListener(Event.ENTER_FRAME,startTimer);
		}
		/**
		 * Converts the timer delay to frames per second rather than seconds
		 **/
		private function onAdd(e:Event):void {
			stage.showDefaultContextMenu = false;//removes part of right-click
			timerDelay*=stage.frameRate;
			removeEventListener(Event.ADDED_TO_STAGE,onAdd);
		}
		/**
		 * Adds the x and y places where the buttons will be (order matters)
		 **/
		private function addButtonPlaces():void {
			buttons[0] = new Array(1025,237.5);
			buttons[1] = new Array(1025,275);
			buttons[2] = new Array(1025,312.5);
			buttons[3] = new Array(1025,350);
		}
		/**
		 * Adds items to the display list
		 **/
		private function addItems():void {
			
			//Backgrounds
			addChild(backgroundLayer);
			backgroundLayer.createFrame(startFrame);
			
			//Buttons
			addChild(buttonLayer);
			for(var a:uint = 0;a < buttons.length; a++){
				buttonMCs[a] = new Btn(a,buttons[a][0],buttons[a][1],buttonSize[0],buttonSize[1]);
				buttonLayer.addChild(buttonMCs[a]);
				buttonMCs[a].updateCurrent(currFrame);
			}
			
			//Cover
			addChild(coverLayer);
			coverLayer.addChild(cover);
		}
		/**
		 * Starts the loop to move the backgrounds
		 **/
		private function startTimer(e:Event):void {
			if(timer==timerDelay){//update
				currFrame++;
				switchBg();
			} else {
				timer++;
			}
		}
		public function gotoFrame(frameNum:uint):void {
			if(currFrame!=frameNum){//if not already on the frame
				currFrame = frameNum;
				switchBg();
			}
		}
		private function switchBg():void {
			timer = 0;
			if(currFrame==buttons.length){
				currFrame = 0;
			}
			backgroundLayer.pushFrame("Random",previousFrame,currFrame);
			previousFrame = currFrame;
			//Update buttons
			for(var a:uint = 0;a < buttons.length; a++){
				buttonMCs[a].updateCurrent(currFrame);
			}
		}
	}
}