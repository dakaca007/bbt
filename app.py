# -*- coding: utf-8 -*-
from flask import Flask, request, jsonify, render_template, Response,redirect


from wtforms import Form, StringField, SubmitField
from wtforms.validators import DataRequired, Length
import requests
import subprocess
import json
import os
from werkzeug.utils import secure_filename
import sys
 
app = Flask(__name__, static_folder='static', static_url_path='/static')
# MySQL数据库配置
app.config['MYSQL_HOST'] = 'mysql.sqlpub.com'
app.config['MYSQL_USER'] = 'dakaca007'
app.config['MYSQL_PASSWORD'] = 'Kgds63EecpSlAtYR'
app.config['MYSQL_DB'] = 'dakaca'
 

# 设置您的OpenAI API密钥
API_KEY = 'sk-v0BzWI6VT5breOqW7wkhm2JAX8G0cefvBPwj1uYrPM1dWWcU'
API_URL = 'https://api.chatanywhere.tech'
# 定义与GPT-3.5对话的函数
def chat_with_gpt3(messages):
    headers = {
        'Authorization': f'Bearer {API_KEY}',
        'Content-Type': 'application/json'
    }
    
    data = {
        'model': 'gpt-3.5-turbo',
        'messages': messages,
        'max_tokens': 150,
        'temperature': 0.7
    }
    
    response = requests.post(API_URL, headers=headers, json=data)
    
    if response.status_code == 200:
        return response.json()['choices'][0]['message']['content']
    else:
        return f"Error: {response.status_code}, {response.text}"
@app.route('/ai')
def indexai():
    return render_template('indexai.html')
@app.route('/chat', methods=['POST'])
def chat():
    user_message = request.json['message']
    messages = request.json['messages']
    
    # 将用户消息添加到历史记录
    messages.append({"role": "user", "content": user_message})
    
    # 调用GPT-3.5获取响应
    gpt_response = chat_with_gpt3(messages)
    
    # 将GPT的响应添加到历史记录
    messages.append({"role": "assistant", "content": gpt_response})
    
    return jsonify({'response': gpt_response, 'messages': messages})
@app.route('/php', methods=['GET', 'POST'])
def indexphp():
    if request.method == 'POST':
        php_code = request.form.get('php_code')
        # 创建临时文件存储 PHP 代码
        with open('temp.php', 'w', encoding='utf-8') as f:
            f.write(php_code)

        # 执行 PHP 代码
        try:
            # 在这里添加设置 PHP 内部编码的代码
            result = subprocess.check_output(['php', '-d', 'mbstring.internal_encoding=UTF-8', 'temp.php'], stderr=subprocess.STDOUT)
            result = result.decode('utf-8')  # 解码输出结果
        except subprocess.CalledProcessError as e:
            result = f"Error: {e.output.decode('utf-8')}"

        return render_template('indexphp.html', php_code=php_code, result=result)
    else:
        return render_template('indexphp.html')
 
@app.route("/ls")
def linxuls():
    return render_template('linuxls.html')  # 仅返回表单页面
@app.route("/v")
def linuxv():
    return render_template('linuxv.html')  # 仅返回表单页面
@app.route("/execute_command", methods=["POST"])
def execute_command():
    command = request.form.get("command")  # 获取用户输入的命令
    if not command:
        return "请输入要执行的命令"

    try:
        output = subprocess.check_output(command.split())  # 执行命令
        return render_template('linuxls.html', html_content=output.decode("utf-8"))
    except subprocess.CalledProcessError as e:
        return f"命令执行失败: {e.output.decode('utf-8')}"  # 处理错误
 
def list_files(directory):
    file_list_html = '<ul>'
    for root, dirs, files in os.walk(directory):
        for file in files:
            # 构建文件链接
            file_path = os.path.relpath(os.path.join(root, file), directory)
             
            file_url = f"/static/{file_path}"
            edit_url = f"/edit/{file_path}"
            delete_url = f"/delete/{file_path}"
            rename_url = f"/rename/{file_path}"  # 添加重命名链接
            file_list_html += f'<li><a href="{file_url}">{file_path}</a> <a href="{edit_url}">编辑</a> <a href="{delete_url}">删除</a> <a href="{rename_url}">重命名</a></li>'
    file_list_html += '</ul>'
    return file_list_html   




@app.route('/new', methods=['GET', 'POST'])
def new_file():
    if request.method == 'POST':
        filename = request.form['filename']
        content = request.form['content']
        # 保存新建的文件到指定路径
        file_path = os.path.join(app.root_path, 'static', filename)
        with open(file_path, 'w', encoding='utf-8') as file:
            file.write(content)
        return redirect('/upload')  # 重定向到/upload路由
    else:
        return render_template('newfile.html')
@app.route('/upload', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        file = request.files['file']
        if file:
            # 保存上传的文件到指定路径
            filename = secure_filename(file.filename)
            # 使用 latin-1 编码处理文件名
            if sys.version_info.major < 3:
                filename = filename.decode('utf-8').encode('latin-1')
            else:
                filename = filename.encode('latin-1').decode('latin-1')
            file.save(os.path.join(app.root_path, 'static', filename))
            return redirect('/upload')
    else:
        # 获取static目录下的所有文件和子目录
        file_list_html = list_files(os.path.join(app.root_path, 'static'))
        # 构建完整的HTML页面
        return render_template('upload.html', file_list_html=file_list_html)

@app.route('/edit/<path:filename>', methods=['GET', 'POST'])
def edit_file(filename):
    file_path = os.path.join(app.root_path, 'static', filename)
    if request.method == 'POST':
        content = request.form['content']
        with open(file_path, 'w',encoding='utf-8') as file:
            file.write(content)
        return redirect('/upload')  # 重定向到/upload路由
    else:
        with open(file_path, 'r',encoding='utf-8') as file:
            content = file.read()
        return render_template('edit.html', filename=filename, content=content)

@app.route('/delete/<path:filename>', methods=['GET', 'POST'])
def delete_file2(filename):
    file_path = os.path.join(app.root_path, 'static', filename)
    if request.method == 'POST':
        os.remove(file_path)
        return redirect('/upload')  # 重定向到/upload路由
    else:
        return render_template('delete.html', filename=filename)
@app.route('/rename/<path:filename>', methods=['GET', 'POST'])
def rename_file(filename):
    file_path = os.path.join(app.root_path, 'static', filename)
    if request.method == 'POST':
        new_filename = request.form.get('new_filename')
        new_file_path = os.path.join(app.root_path, 'static', new_filename)
        os.rename(file_path, new_file_path)
        return redirect('/upload')  # 重定向到文件上传页面
    else:
        return render_template('rename.html', filename=filename)



@app.route('/api', methods=['POST'])
def api():
    data = request.get_json()
    text = data['text']
    response = {
        'text': text
    }
    return jsonify(response)

@app.route("/")
def index():


    # 定义参数字典
    params = {'user_name': 'John Doe', 'product_id': '12345'}
    # 构建参数列表
    param_list = ['php', 'index.php']
    for key, value in params.items():
        param_list.append(f'{key}={value}')
    # 执行 PHP 脚本，并将参数传递给它
    process = subprocess.check_output(param_list)
    # 获取 PHP 脚本输出的 HTML 内容
    html_content = process.decode('utf-8')
    # 在 Flask 模板中渲染 HTML 内容
    return render_template('index.html', html_content=html_content)

#完美的分界线




# 从配置文件中settings加载配置
app.config.from_pyfile('set.py')

 
 
 

     
 





if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
