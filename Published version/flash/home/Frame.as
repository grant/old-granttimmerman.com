package {
	import flash.display.MovieClip;
	import flash.events.MouseEvent;
	import flash.net.URLRequest;
	import flash.net.navigateToURL;
	public class Frame extends MovieClip {
		public var backgrounds:Array = new Array();
		private var bgNumber:uint;
		
		public function Frame(bgNum:uint):void {
			bgNumber = bgNum;
			this.cacheAsBitmap = true;
			this.buttonMode = true;
			addBackgroundPlaces();
			addChild(backgrounds[bgNum]);
			addEventListener(MouseEvent.CLICK,onClick);
		}		
		private function onClick(e:MouseEvent):void {
			var url:String = "";
			switch(bgNumber){
				case 0:
				url = "./games/index.php";
				break;
				case 1:
				url = "./games/index.php";
				break;
				case 2:
				url = "./games/index.php";
				break;
				case 3:
				url = "./games/index.php";
				break;
			}
			var req:URLRequest = new URLRequest(url);
			navigateToURL(req, '_blank');
		}
		private function addBackgroundPlaces():void {
			backgrounds[0] = new Bg1();
			backgrounds[1] = new Bg2();
			backgrounds[2] = new Bg3();
			backgrounds[3] = new Bg4();
		}
	}
}