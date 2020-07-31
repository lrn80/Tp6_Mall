#### 基础架构分层逻辑

后端使用的是五层架构，打破了传统的MVC的三层架构，把主要的业务逻辑放到了bussiness层是控制器层更加简洁。每一层的职责更加清晰，项目的维护成本也大大降低。

<img src="images/mall-1.png" style="zoom:40%;" />

#### 用户登陆逻辑

**后端登录**

使用的是Ajax请求后端接口，后端进行校验以及用户状态的存储。

<img src="images/mall-2.png" style="zoom:50%;" />

**前端登录**

前端这里使用了用户手机号获取验证码的方式登录，具体的流程如下图：

<img src="images/mall-3.png" style="zoom:50%;" />