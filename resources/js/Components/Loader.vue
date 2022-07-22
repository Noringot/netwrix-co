<template>
  <div class="loader">
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
    <div class="circle circle-3"></div>
  </div>
</template>

<style>

  .loader {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.6);
    opacity: 1;
    transition: 0.2s all ease;
    animation-name: load;
    animation-iteration-count: infinite;
    animation-duration: 1.5s;
    margin-left: 10px;
  }
  .circle:first-child {margin-left: 0}
  .circle-1 {animation-delay: 0s}
  .circle-2 {animation-delay: 0.2s}
  .circle-3 {animation-delay: 0.4s}
  @keyframes load {
    0% {
      opacity: 1;
    }
    50% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

</style>
