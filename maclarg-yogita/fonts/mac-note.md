# mac-note
* style.css 
  :root{
  --upod-font: 6rem;
}
.project-detail{
  font-family: 'quicksand';
}
.text-u{
  font-size: var(--upod-font);
  position: relative;
}
.text-pod{
  font-size: calc(var(--upod-font) - 1rem);
  position: relative;
  transform: translateY(-11px);
  display: inline-block;
}
.text-u::before{
  content: "";
  position: absolute;
  top: 30px;
  left: 50%;
  transform: translate(-50%, 0);
  border-top: 10px solid #91cf58;
  border-radius: 10px;
  width: 85%;
}
.text-pod::after{
  content: "";
  position: absolute;
  bottom: 14px;
  left: 50%;
  transform: translate(-50%, 0);
  border-top: 10px solid #91cf58;
  border-radius: 10px;
  width: 93%;
}
.text-upod-sub{
  font-size: calc(var(--upod-font) - 2rem);
}
.text-upod-sub span:nth-child(1){
  color: #91cf58;
}

