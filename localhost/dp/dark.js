 let themeMode; // 2: 自动， 1: 浅色，0: 深色
        let autoThemeMode; // 1: 跟随系统，0:自定义时间
        let customDarkTime; // 开始，结束时间
        let isFull = false; // 是否全屏
        const darkMedia = window.matchMedia("(prefers-color-scheme: dark)");
        const justDarkTheme = (is) => {
            if (is) document.documentElement.setAttribute("data-theme", "dark");
            else document.documentElement.removeAttribute("data-theme");
            document.head.children[4].content = document.head.children[5].content = document.head.children[6].content = getComputedStyle(document.documentElement).getPropertyValue("--background");
        }
        const checkDark = () => {
            const checkCustomTheme = () => {
                let date = new Date();
                let nowTime = date.getTime();
                let start = customDarkTime[0].split(":");
                let startTime = new Date().setHours(start[0], start[1], 0, 0);
                let end = customDarkTime[1].split(":");
                let endTime = new Date().setHours(end[0], end[1], 0, 0);
                let order = endTime > startTime;
                let isDark = order ? (nowTime > startTime && endTime > nowTime) : !(nowTime > endTime && startTime > nowTime);
                justDarkTheme(isDark);
            }
            const setDarkMode = () => {
                if (themeMode === 2) {
                    if (autoThemeMode) {
                        justDarkTheme(darkMedia.matches);
                    } else {
                        checkCustomTheme();
                    }
                } else if (themeMode === 1) {
                    justDarkTheme(false);
                } else {
                    justDarkTheme(true);
                }
                localStorage.setItem("themeMode", themeMode);
            }
            let localTheme = localStorage.getItem("themeMode");
            themeMode = parseInt(localTheme || "1");
            let localAutoTheme = localStorage.getItem("autoThemeMode");
            autoThemeMode = parseInt(localAutoTheme || "1");
            let localCustomDark = localStorage.getItem("customDarkTime");
            customDarkTime = JSON.parse(localCustomDark || '["21:00", "07:00"]');
            setDarkMode();
        }
        checkDark();
