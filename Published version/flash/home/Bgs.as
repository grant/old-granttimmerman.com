//Background layer
package {
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.net.URLRequest;
	public class Bgs extends MovieClip {
		private var id:uint;
		public var frames:Array;

		private var xdes:int=0;
		private var ydes:int=0;

		private const stopDis:uint=2;
		private const ease:Number=0.1;

		private var par:MovieClip;
		public function Bgs():void {
			this.cacheAsBitmap = true;
			addEventListener(Event.ADDED_TO_STAGE,onAdd);
			addEventListener(Event.ENTER_FRAME,moveXY);
		}
		private function onAdd(e:Event):void {
			par=MovieClip(parent);
			frames = new Array();
			for (var i:uint = 0; i<par.buttons.length; i++) {
				frames[i]=new Frame(i);
				addChild(frames[i]);
				frames[i].x=- frames[i].width;
				frames[i].y=- frames[i].height;
			}
			removeEventListener(Event.ADDED_TO_STAGE,onAdd);
		}
		private function moveXY(e:Event):void {
			if (Math.abs(x-xdes)<stopDis&&Math.abs(y-ydes)<stopDis) {
				x=xdes;
				y=ydes;
			} else {
				if (xdes-x<0) {
					x--;
				} else if (xdes-x>0) {
					x++;
				}
				if (ydes-y<0) {
					y--;
				} else if (ydes-y>0) {
					y++;
				}
				x += (xdes-x)*ease;
				y += (ydes-y)*ease;
			}
		}
		/**
		 * Creates a frame and makes it move
		 * Params: dir = the direction in a string
		 *         currBg = the background wished to display
		 **/
		public function pushFrame(dir:String,prevBg:uint,currBg:uint):void {
			//set all to invisible
			for (var i:uint = 0; i<par.buttons.length; i++) {
				frames[i].visible=false;
			}
			frames[prevBg].visible=true;
			frames[currBg].visible=true;

			//direction
			var position:String=dir;
			if (position=="Random"||position=="Horizontal"||position=="Vertical") {
				position=findDirection(position);
			}

			switch (position) {
				case "Up" :
					x=0;
					y=0;
					xdes=0;
					ydes=- frames[currBg].height;
					//previous frame
					frames[prevBg].x=0;
					frames[prevBg].y=0;
					//current frame
					frames[currBg].x=0;
					frames[currBg].y=frames[currBg].height;
					break;
				case "Left" :
					x=0;
					y=0;
					//Glitched (off by 1) xdes=- frames[currBg].width;
					xdes = -1075;
					ydes=0;
					//previous frame
					frames[prevBg].x=0;
					frames[prevBg].y=0;
					//current frame
					frames[currBg].x=frames[currBg].width;
					frames[currBg].y=0;
					break;
				case "Right" :
					x=0;
					y=0;
					//Glitched (off by 1) xdes=frames[currBg].width;
					xdes = 1075;
					ydes=0;
					//previous frame
					frames[prevBg].x=0;
					frames[prevBg].y=0;
					//current frame
					frames[currBg].x=- frames[currBg].width;
					frames[currBg].y=0;
					break;
				case "Down" :
					x=0;
					y=0;
					xdes=0;
					ydes=frames[currBg].height;
					//previous frame
					frames[prevBg].x=0;
					frames[prevBg].y=0;
					//current frame
					frames[currBg].x=0;
					frames[currBg].y=- frames[currBg].height;
					break;
			}
		}
		public function createFrame(currBg:uint):void {
			frames[currBg].x=0;
			frames[currBg].y=0;
		}
		private function findDirection(way:String):String {
			//way is "Random","Horizontal","Vertical"
			var good:Boolean=false;
			var dir:String="";
			var r:uint;
			if (way=="Random") {
				r=Math.floor(Math.random()*4);
			} else if (way=="Horizontal") {
				r=Math.floor(Math.random()*2)+2;
			} else if (way=="Vertical") {
				r=Math.floor(Math.random()*2);
			}
			switch (r) {
				case 0 :
					dir="Up";
					break;
				case 1 :
					dir="Down";
					break;
				case 2 :
					dir="Left";
					break;
				case 3 :
					dir="Right";
					break;
			}
			return dir;
		}
	}
}