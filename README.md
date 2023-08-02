Installation
============

### Requirements
- Download **docker** and **docker-compose** binaries for initialization
- **make** executable

**Step 1:**
- Executing docker as regular user: **(only for linux)**

**Note:** If your docker executable already running by your user then, you can skip this step.

```shell
sudo groupadd docker
sudo usermod -aG docker ${USER}
su -s ${USER}

# For testing
docker --version
```

**Step 2:**

Open a command console, enter your project directory and execute:

```console
$ sudo make init
$ sudo make app-init
$ sudo make app-migrate
$ sudo make app-fixture-load
```


**Step 3:**

For testing api open the http://127.0.0.1:8888/api/doc url:

