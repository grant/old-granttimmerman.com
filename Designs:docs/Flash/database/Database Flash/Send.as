package {
	import flash.display.MovieClip;
	import flash.events.MouseEvent;
	public class Send extends MovieClip {
		public function Send():void {
			addEventListener(MouseEvent.CLICK,onClick);
		}
		private function onClick(e:MouseEvent):void {
			MovieClip(parent).sendReq();
		}
	}
}