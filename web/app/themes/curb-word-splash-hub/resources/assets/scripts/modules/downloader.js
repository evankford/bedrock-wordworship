export default class Downloader {
  constructor(el) {
    this.el = el;
    this.reset = this.resetProgress.bind(this);
    this.progress = this.addProgress.bind(this);
    this.ticker;
    this.init();
  }

  init() {
    var button = this.el.querySelector('[data-progress-button]')
    button.addEventListener('click', this.progress);
  }

  resetProgress() {
    this.el.classList.remove('progressed')
    clearTimeout(this.ticker);
    this.el.parentNode.removeEventListener('click', this.reset);
  }

  addProgress() {
    this.el.classList.add('progressed');
    this.ticker = setTimeout(() => {
      this.reset();
    }, 10000);
    setTimeout(() => {
      this.el.parentNode.addEventListener('click', (e)=>{
        if (!e.target.classList.contains('download-button')) {
          this.reset()
        }
      });
    }, 400);
  }
}