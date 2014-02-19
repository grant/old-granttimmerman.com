package {
	import flash.display.MovieClip;
	import flash.events.MouseEvent;
	import flash.net.URLRequest;
	import flash.net.navigateToURL;
	public class Frame extends MovieClip {
		public var backgrounds:Array = new Array();
		private var bgNumber:uint;

		public function Frame(bgNum:uint):void {
			bgNumber=bgNum;
			this.cacheAsBitmap=true;
			this.buttonMode=true;
			addBackgroundPlaces();
			addChild(backgrounds[bgNum]);
			addEventListener(MouseEvent.CLICK,onClick);
		}
		private function onClick(e:MouseEvent):void {
			//if not near the navigation buttons
			if (!(stage.mouseX>1000&&stage.mouseY>200)) {
				var url:String="";
				switch (bgNumber) {
					case 0 :
						url="./about/index.php";
						break;
					case 1 :
						url="./games/cellular_warfare.php";
						break;
					case 2 :
						url="./projects/web_camera.php";
						break;
					case 3 :
						url="./games/paint.php";
						break;
				}
				trace(url);
				var req:URLRequest=new URLRequest(url);
				navigateToURL(req, '_blank');
			}
		}
		private function addBackgroundPlaces():void {
			backgrounds[0] = new Bg1();
			backgrounds[1] = new Bg2();
			backgrounds[2] = new Bg3();
			backgrounds[3] = new Bg4();
		}
	}
}