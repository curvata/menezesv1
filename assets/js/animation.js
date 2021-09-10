const options = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
  }

  const reveal_left = document.querySelectorAll('.hl');
  const reveal_right = document.querySelectorAll('.hr');
  const reveal_top = document.querySelectorAll('.ht');
  const reveal_bottom = document.querySelectorAll('.hb');
  
  const observer_left = new IntersectionObserver(callback_left, options);
  const observer_right = new IntersectionObserver(callback_right, options);
  const observer_top = new IntersectionObserver(callback_top, options);
  const observer_bottom = new IntersectionObserver(callback_bottom, options);

  reveal_left.forEach((item) => {
    observer_left.observe(item);
  });

  reveal_top.forEach((item) => {
    observer_top.observe(item);
  });

  reveal_bottom.forEach((item) => {
    observer_bottom.observe(item);
  });

  reveal_right.forEach((item) => {
    observer_right.observe(item);
});

  function callback_left(items, observer)
  {
      items.forEach(item => {
          if (item.intersectionRatio > 0.1) {
              item.target.classList.add("rl");
              let elem = item.target;
          }
      });
  }

  function callback_bottom(items, observer)
  {
      items.forEach(item => {
          if (item.intersectionRatio > 0.1) {
              item.target.classList.add("rb");
              let elem = item.target;
          }
      });
  }

  function callback_top(items, observer)
  {
      items.forEach(item => {
          if (item.intersectionRatio > 0.1) {
              item.target.classList.add("rt");
              let elem = item.target;
          }
      });
  }

  function callback_right(items, observer)
  {
    items.forEach(item => {
        if (item.intersectionRatio > 0.1) {
            item.target.classList.add("rr");
        }
    });
  }