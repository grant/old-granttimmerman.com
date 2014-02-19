package {
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.MouseEvent;
	public class Btn extends MovieClip {
		private var id:uint;
		private var par2:MovieClip;
		private var wid:uint;
		private var hei:uint;
		private var currFrame:uint;
		private var mouseIsOver:Boolean=false;
		public function Btn(i:uint,px:int,py:int,w:uint,h:uint):void {
			id=i;
			x=px;
			y=py;
			wid=w;
			hei=h;
			width=w;
			height=h;
			stop();
			this.cacheAsBitmap = true;
			this.buttonMode = true;
			
			addEventListener(Event.ADDED_TO_STAGE,onAdd);

			addEventListener(MouseEvent.ROLL_OVER,over);
			addEventListener(MouseEvent.ROLL_OUT,out);

			addEventListener(MouseEvent.CLICK,onClick);
		}
		private function onAdd(e:Event):void {
			par2=MovieClip(parent.parent);
			removeEventListener(Event.ADDED_TO_STAGE,onAdd);
		}
		private function over(e:MouseEvent):void {
			mouseIsOver=true;
			if (id==currFrame) {
				gotoAndStop(4);
			} else {
				gotoAndStop(2);
			}
		}
		private function out(e:MouseEvent):void {
			mouseIsOver=false;
			if (id==currFrame) {
				gotoAndStop(3);
			} else {
				gotoAndStop(1);
			}
		}
		private function onClick(e:MouseEvent):void {
			par2.gotoFrame(id);
		}
		public function updateCurrent(current:uint):void {
			currFrame=current;
			if (id==currFrame) {
				if (mouseIsOver) {
					gotoAndStop(4);
				} else {
					gotoAndStop(3);
				}
			} else {
				if (mouseIsOver){
					gotoAndStop(2);
				} else {
					gotoAndStop(1);
				}
			}
		}
	}
}