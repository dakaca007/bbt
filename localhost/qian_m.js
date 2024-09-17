
        // from fflate@0.8.2
        {const t=Uint8Array,e=Uint16Array,n=Int32Array,r=new t([0,0,0,0,0,0,0,0,1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,0,0,0,0]),o=new t([0,0,0,0,1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,11,12,12,13,13,0,0]),l=new t([16,17,18,0,8,7,9,6,10,5,11,4,12,3,13,2,14,1,15]),s=(t,r)=>{const o=new e(31);for(let e=0;e<31;++e)o[e]=r+=1<<t[e-1];const l=new n(o[30]);for(let t=1;t<30;++t)for(let e=o[t];e<o[t+1];++e)l[e]=e-o[t]<<5|t;return{b:o,r:l}},{b:f,r:c}=s(r,2);f[28]=258,c[258]=28;const{b:i,r:a}=s(o,0),h=new e(32768);for(let t=0;t<32768;++t){let e=(43690&t)>>1|(21845&t)<<1;e=(52428&e)>>2|(13107&e)<<2,e=(61680&e)>>4|(3855&e)<<4,h[t]=((65280&e)>>8|(255&e)<<8)>>1}const u=(t,n,r)=>{const o=t.length;let l=0;const s=new e(n);for(;l<o;++l)t[l]&&++s[t[l]-1];const f=new e(n);for(l=1;l<n;++l)f[l]=f[l-1]+s[l-1]<<1;let c;if(r){c=new e(1<<n);const r=15-n;for(l=0;l<o;++l)if(t[l]){const e=l<<4|t[l],o=n-t[l];let s=f[t[l]-1]++<<o;for(const t=s|(1<<o)-1;s<=t;++s)c[h[s]>>r]=e}}else for(c=new e(o),l=0;l<o;++l)t[l]&&(c[l]=h[f[t[l]-1]++]>>15-t[l]);return c},w=new t(288);for(let t=0;t<144;++t)w[t]=8;for(let t=144;t<256;++t)w[t]=9;for(let t=256;t<280;++t)w[t]=7;for(let t=280;t<288;++t)w[t]=8;const g=new t(32);for(let t=0;t<32;++t)g[t]=5;const b=u(w,9,0),d=u(w,9,1),m=u(g,5,0),y=u(g,5,1),M=t=>{let e=t[0];for(let n=1;n<t.length;++n)t[n]>e&&(e=t[n]);return e},p=(t,e,n)=>{const r=e/8|0;return(t[r]|t[r+1]<<8)>>(7&e)&n},k=(t,e)=>{const n=e/8|0;return(t[n]|t[n+1]<<8|t[n+2]<<16)>>(7&e)},v=t=>(t+7)/8|0,x=(e,n,r)=>((null==n||n<0)&&(n=0),(null==r||r>e.length)&&(r=e.length),new t(e.subarray(n,r))),E=["unexpected EOF","invalid block type","invalid length/literal","invalid distance","stream finished","no stream handler",,"no callback","invalid UTF-8 data","extra field too long","date not in range 1980-2099","filename too long","stream finishing","invalid zip data"],A=(t,e,n)=>{const r=new Error(e||E[t]);if(r.code=t,Error.captureStackTrace&&Error.captureStackTrace(r,A),!n)throw r;return r},T=(e,n,s,c)=>{const a=e.length,h=c?c.length:0;if(!a||n.f&&!n.l)return s||new t(0);const w=!s,g=w||2!=n.i,b=n.i;w&&(s=new t(3*a));const m=e=>{let n=s.length;if(e>n){const r=new t(Math.max(2*n,e));r.set(s),s=r}};let E=n.f||0,T=n.p||0,U=n.b||0,z=n.l,F=n.d,S=n.m,I=n.n;const O=8*a;do{if(!z){E=p(e,T,1);const r=p(e,T+1,3);if(T+=3,!r){const t=v(T)+4,r=e[t-4]|e[t-3]<<8,o=t+r;if(o>a){b&&A(0);break}g&&m(U+r),s.set(e.subarray(t,o),U),n.b=U+=r,n.p=T=8*o,n.f=E;continue}if(1==r)z=d,F=y,S=9,I=5;else if(2==r){const n=p(e,T,31)+257,r=p(e,T+10,15)+4,o=n+p(e,T+5,31)+1;T+=14;const s=new t(o),f=new t(19);for(let t=0;t<r;++t)f[l[t]]=p(e,T+3*t,7);T+=3*r;const c=M(f),i=(1<<c)-1,a=u(f,c,1);for(let t=0;t<o;){const n=a[p(e,T,i)];T+=15&n;const r=n>>4;if(r<16)s[t++]=r;else{let n=0,o=0;for(16==r?(o=3+p(e,T,3),T+=2,n=s[t-1]):17==r?(o=3+p(e,T,7),T+=3):18==r&&(o=11+p(e,T,127),T+=7);o--;)s[t++]=n}}const h=s.subarray(0,n),w=s.subarray(n);S=M(h),I=M(w),z=u(h,S,1),F=u(w,I,1)}else A(1);if(T>O){b&&A(0);break}}g&&m(U+131072);const w=(1<<S)-1,x=(1<<I)-1;let j=T;for(;;j=T){const t=z[k(e,T)&w],n=t>>4;if(T+=15&t,T>O){b&&A(0);break}if(t||A(2),n<256)s[U++]=n;else{if(256==n){j=T,z=null;break}{let t=n-254;if(n>264){const o=n-257,l=r[o];t=p(e,T,(1<<l)-1)+f[o],T+=l}const l=F[k(e,T)&x],a=l>>4;l||A(3),T+=15&l;let u=i[a];if(a>3){const t=o[a];u+=k(e,T)&(1<<t)-1,T+=t}if(T>O){b&&A(0);break}g&&m(U+131072);const w=U+t;if(U<u){const t=h-u,e=Math.min(u,w);for(t+U<0&&A(3);U<e;++U)s[U]=c[t+U]}for(;U<w;++U)s[U]=s[U-u]}}}n.l=z,n.p=j,n.b=U,n.f=E,z&&(E=1,n.m=S,n.d=F,n.n=I)}while(!E);return U!=s.length&&w?x(s,0,U):s.subarray(0,U)},U=(t,e,n)=>{n<<=7&e;const r=e/8|0;t[r]|=n,t[r+1]|=n>>8},z=(t,e,n)=>{n<<=7&e;const r=e/8|0;t[r]|=n,t[r+1]|=n>>8,t[r+2]|=n>>16},F=(n,r)=>{const o=[];for(let t=0;t<n.length;++t)n[t]&&o.push({s:t,f:n[t]});const l=o.length,s=o.slice();if(!l)return{t:C,l:0};if(1==l){const e=new t(o[0].s+1);return e[o[0].s]=1,{t:e,l:1}}o.sort(((t,e)=>t.f-e.f)),o.push({s:-1,f:25001});let f=o[0],c=o[1],i=0,a=1,h=2;for(o[0]={s:-1,f:f.f+c.f,l:f,r:c};a!=l-1;)f=o[o[i].f<o[h].f?i++:h++],c=o[i!=a&&o[i].f<o[h].f?i++:h++],o[a++]={s:-1,f:f.f+c.f,l:f,r:c};let u=s[0].s;for(let t=1;t<l;++t)s[t].s>u&&(u=s[t].s);const w=new e(u+1);let g=S(o[a-1],w,0);if(g>r){let t=0,e=0;const n=g-r,o=1<<n;for(s.sort(((t,e)=>w[e.s]-w[t.s]||t.f-e.f));t<l;++t){const n=s[t].s;if(!(w[n]>r))break;e+=o-(1<<g-w[n]),w[n]=r}for(e>>=n;e>0;){const n=s[t].s;w[n]<r?e-=1<<r-w[n]++-1:++t}for(;t>=0&&e;--t){const n=s[t].s;w[n]==r&&(--w[n],++e)}g=r}return{t:new t(w),l:g}},S=(t,e,n)=>-1==t.s?Math.max(S(t.l,e,n+1),S(t.r,e,n+1)):e[t.s]=n,I=t=>{let n=t.length;for(;n&&!t[--n];);const r=new e(++n);let o=0,l=t[0],s=1;const f=t=>{r[o++]=t};for(let e=1;e<=n;++e)if(t[e]==l&&e!=n)++s;else{if(!l&&s>2){for(;s>138;s-=138)f(32754);s>2&&(f(s>10?s-11<<5|28690:s-3<<5|12305),s=0)}else if(s>3){for(f(l),--s;s>6;s-=6)f(8304);s>2&&(f(s-3<<5|8208),s=0)}for(;s--;)f(l);s=1,l=t[e]}return{c:r.subarray(0,o),n:n}},O=(t,e)=>{let n=0;for(let r=0;r<e.length;++r)n+=t[r]*e[r];return n},j=(t,e,n)=>{const r=n.length,o=v(e+2);t[o]=255&r,t[o+1]=r>>8,t[o+2]=255^t[o],t[o+3]=255^t[o+1];for(let e=0;e<r;++e)t[o+e+4]=n[e];return 8*(o+4+r)},q=(t,n,s,f,c,i,a,h,d,y,M)=>{U(n,M++,s),++c[256];const{t:p,l:k}=F(c,15),{t:v,l:x}=F(i,15),{c:E,n:A}=I(p),{c:T,n:S}=I(v),q=new e(19);for(let t=0;t<E.length;++t)++q[31&E[t]];for(let t=0;t<T.length;++t)++q[31&T[t]];const{t:B,l:C}=F(q,7);let D=19;for(;D>4&&!B[l[D-1]];--D);const G=y+5<<3,H=O(c,w)+O(i,g)+a,J=O(c,p)+O(i,v)+a+14+3*D+O(q,B)+2*q[16]+3*q[17]+7*q[18];if(d>=0&&G<=H&&G<=J)return j(n,M,t.subarray(d,d+y));let K,L,N,P;if(U(n,M,1+(J<H)),M+=2,J<H){K=u(p,k,0),L=p,N=u(v,x,0),P=v;const t=u(B,C,0);U(n,M,A-257),U(n,M+5,S-1),U(n,M+10,D-4),M+=14;for(let t=0;t<D;++t)U(n,M+3*t,B[l[t]]);M+=3*D;const e=[E,T];for(let r=0;r<2;++r){const o=e[r];for(let e=0;e<o.length;++e){const r=31&o[e];U(n,M,t[r]),M+=B[r],r>15&&(U(n,M,o[e]>>5&127),M+=o[e]>>12)}}}else K=b,L=w,N=m,P=g;for(let t=0;t<h;++t){const e=f[t];if(e>255){const t=e>>18&31;z(n,M,K[t+257]),M+=L[t+257],t>7&&(U(n,M,e>>23&31),M+=r[t]);const l=31&e;z(n,M,N[l]),M+=P[l],l>3&&(z(n,M,e>>5&8191),M+=o[l])}else z(n,M,K[e]),M+=L[e]}return z(n,M,K[256]),M+L[256]},B=new n([65540,131080,131088,131104,262176,1048704,1048832,2114560,2117632]),C=new t(0),D=(l,s,f,i,h,u)=>{const w=u.z||l.length,g=new t(i+w+5*(1+Math.ceil(w/7e3))+h),b=g.subarray(i,g.length-h),d=u.l;let m=7&(u.r||0);if(s){m&&(b[0]=u.r>>3);const t=B[s-1],i=t>>13,h=8191&t,g=(1<<f)-1,y=u.p||new e(32768),M=u.h||new e(g+1),p=Math.ceil(f/3),k=2*p,v=t=>(l[t]^l[t+1]<<p^l[t+2]<<k)&g,x=new n(25e3),E=new e(288),A=new e(32);let T=0,U=0,z=u.i||0,F=0,S=u.w||0,I=0;for(;z+2<w;++z){const t=v(z);let e=32767&z,n=M[t];if(y[e]=n,M[t]=e,S<=z){const s=w-z;if((T>7e3||F>24576)&&(s>423||!d)){m=q(l,b,0,x,E,A,U,F,I,z-I,m),F=T=U=0,I=z;for(let t=0;t<286;++t)E[t]=0;for(let t=0;t<30;++t)A[t]=0}let f=2,u=0,g=h,M=e-n&32767;if(s>2&&t==v(z-M)){const t=Math.min(i,s)-1,r=Math.min(32767,z),o=Math.min(258,s);for(;M<=r&&--g&&e!=n;){if(l[z+f]==l[z+f-M]){let e=0;for(;e<o&&l[z+e]==l[z+e-M];++e);if(e>f){if(f=e,u=M,e>t)break;const r=Math.min(M,e-2);let o=0;for(let t=0;t<r;++t){const e=z-M+t&32767,r=e-y[e]&32767;r>o&&(o=r,n=e)}}}e=n,n=y[e],M+=e-n&32767}}if(u){x[F++]=268435456|c[f]<<18|a[u];const t=31&c[f],e=31&a[u];U+=r[t]+o[e],++E[257+t],++A[e],S=z+f,++T}else x[F++]=l[z],++E[l[z]]}}for(z=Math.max(z,S);z<w;++z)x[F++]=l[z],++E[l[z]];m=q(l,b,d,x,E,A,U,F,I,z-I,m),d||(u.r=7&m|b[m/8|0]<<3,m-=7,u.h=M,u.p=y,u.i=z,u.w=S)}else{for(let t=u.w||0;t<w+d;t+=65535){let e=t+65535;e>=w&&(b[m/8|0]=d,e=w),m=j(b,m+1,l.subarray(t,e))}u.i=w}return x(g,0,i+v(m)+h)},G=(e,n,r,o,l)=>{if(!l&&(l={l:1},n.dictionary)){const r=n.dictionary.subarray(-32768),o=new t(r.length+e.length);o.set(r),o.set(e,r.length),e=o,l.w=r.length}return D(e,null==n.level?6:n.level,null==n.mem?l.l?Math.ceil(1.5*Math.max(8,Math.min(13,Math.log(e.length)))):20:12+n.mem,r,o,l)};function deflateSync(t,e){return G(t,e||{},0,0)}function inflateSync(t,e){return T(t,{i:2},e&&e.out,e&&e.dictionary)}};
        // from markdown-it-texmath@1.0.1
        function escapeHTML(e){return e.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&apos;").replace(/\//g,"&sol;")}function texmath(e,t){const n=texmath.mergeDelimiters(t&&t.delimiters),a=t&&t.outerSpace||!1,o=t&&t.katexOptions||{};o.throwOnError=o.throwOnError||!1,o.macros=o.macros||t&&t.macros,texmath.katex||(t&&"object"==typeof t.engine?texmath.katex=t.engine:"object"==typeof module?texmath.katex=require("katex"):texmath.katex={renderToString:()=>"No math renderer found."});for(const t of n.inline)a&&"outerSpace"in t&&(t.outerSpace=!0),e.inline.ruler.before("escape",t.name,texmath.inline(t)),e.renderer.rules[t.name]=(e,n)=>t.tmpl.replace(/\$1/,texmath.render(e[n].content,!!t.displayMode,o));for(const t of n.block)e.block.ruler.before("fence",t.name,texmath.block(t)),e.renderer.rules[t.name]=(e,n)=>t.tmpl.replace(/\$2/,escapeHTML(e[n].info)).replace(/\$1/,texmath.render(e[n].content,!0,o))}texmath.mergeDelimiters=function(e){const t=Array.isArray(e)?e:"string"==typeof e?[e]:["dollars"],n={inline:[],block:[]};for(const e of t)e in texmath.rules&&(n.inline.push(...texmath.rules[e].inline),n.block.push(...texmath.rules[e].block));return n},texmath.inline=e=>function(t,n){const a=t.pos,o=t.src,r=o.startsWith(e.tag,e.rex.lastIndex=a)&&(!e.pre||e.pre(o,e.outerSpace,a))&&e.rex.exec(o),s=!!r&&a<e.rex.lastIndex&&(!e.post||e.post(o,e.outerSpace,e.rex.lastIndex-1));if(s){if(!n){const n=t.push(e.name,"math",0);n.content=r[1],n.markup=e.tag}t.pos=e.rex.lastIndex}return s},texmath.block=e=>function(t,n,a,o){const r=t.bMarks[n]+t.tShift[n],s=t.src,m=s.startsWith(e.tag,e.rex.lastIndex=r)&&(!e.pre||e.pre(s,!1,r))&&e.rex.exec(s),l=!!m&&r<e.rex.lastIndex&&(!e.post||e.post(s,!1,e.rex.lastIndex-1));if(l&&!o){const o=e.rex.lastIndex-1;let r;for(r=n;r<a&&!(o>=t.bMarks[r]+t.tShift[r]&&o<=t.eMarks[r]);r++);const s=t.lineMax,l=t.parentType;t.lineMax=r,t.parentType="math","blockquote"===l&&(m[1]=m[1].replace(/(\n*?^(?:\s*>)+)/gm,""));let c=t.push(e.name,"math",0);c.block=!0,c.tag=e.tag,c.markup="",c.content=m[1],c.info=m[m.length-1],c.map=[n,r+1],t.parentType=l,t.lineMax=s,t.line=r+1}return l},texmath.render=function(e,t,n){let a;n.displayMode=t;try{a=texmath.katex.renderToString(e,n)}catch(t){a=escapeHTML(`${e}:${t.message}`)}return a},texmath.inlineRuleNames=["math_inline","math_inline_double"],texmath.blockRuleNames=["math_block","math_block_eqno"],texmath.$_pre=(e,t,n)=>{const a=n>0&&e[n-1].charCodeAt(0);return t?!a||32===a:!a||92!==a&&(a<48||a>57)},texmath.$_post=(e,t,n)=>{const a=e[n+1]&&e[n+1].charCodeAt(0);return t?!a||32===a||46===a||44===a||59===a:!a||a<48||a>57},texmath.rules={brackets:{inline:[{name:"math_inline",rex:/\\\((.+?)\\\)/gy,tmpl:"<eq>$1</eq>",tag:"\\("}],block:[{name:"math_block_eqno",rex:/\\\[(((?!\\\]|\\\[)[\s\S])+?)\\\]\s*?\(([^)$\r\n]+?)\)/gmy,tmpl:'<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',tag:"\\["},{name:"math_block",rex:/\\\[([\s\S]+?)\\\]/gmy,tmpl:"<section><eqn>$1</eqn></section>",tag:"\\["}]},doxygen:{inline:[{name:"math_inline",rex:/\\f\$(.+?)\\f\$/gy,tmpl:"<eq>$1</eq>",tag:"\\f$"}],block:[{name:"math_block_eqno",rex:/\\f\[([^]+?)\\f\]\s*?\(([^)\s]+?)\)/gmy,tmpl:'<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',tag:"\\f["},{name:"math_block",rex:/\\f\[([^]+?)\\f\]/gmy,tmpl:"<section><eqn>$1</eqn></section>",tag:"\\f["}]},gitlab:{inline:[{name:"math_inline",rex:/\$`(.+?)`\$/gy,tmpl:"<eq>$1</eq>",tag:"$`"}],block:[{name:"math_block_eqno",rex:/`{3}math\s*([^`]+?)\s*?`{3}\s*\(([^)\r\n]+?)\)/gm,tmpl:'<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',tag:"```math"},{name:"math_block",rex:/`{3}math\s*([^`]*?)\s*`{3}/gm,tmpl:"<section><eqn>$1</eqn></section>",tag:"```math"}]},julia:{inline:[{name:"math_inline",rex:/`{2}([^`]+?)`{2}/gy,tmpl:"<eq>$1</eq>",tag:"``"},{name:"math_inline",rex:/\$((?:\S?)|(?:\S.*?\S))\$/gy,tmpl:"<eq>$1</eq>",tag:"$",spaceEnclosed:!1,pre:texmath.$_pre,post:texmath.$_post}],block:[{name:"math_block_eqno",rex:/`{3}math\s+?([^`]+?)\s+?`{3}\s*?\(([^)$\r\n]+?)\)/gmy,tmpl:'<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',tag:"```math"},{name:"math_block",rex:/`{3}math\s+?([^`]+?)\s+?`{3}/gmy,tmpl:"<section><eqn>$1</eqn></section>",tag:"```math"}]},kramdown:{inline:[{name:"math_inline",rex:/\${2}(.+?)\${2}/gy,tmpl:"<eq>$1</eq>",tag:"$$"}],block:[{name:"math_block_eqno",rex:/\${2}([^$]+?)\${2}\s*?\(([^)\s]+?)\)/gmy,tmpl:'<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',tag:"$$"},{name:"math_block",rex:/\${2}([^$]+?)\${2}/gmy,tmpl:"<section><eqn>$1</eqn></section>",tag:"$$"}]},beg_end:{inline:[],block:[{name:"math_block",rex:/(\\(?:begin)\{([a-z]+)\}[\s\S]+?\\(?:end)\{\2\})/gmy,tmpl:"<section><eqn>$1</eqn></section>",tag:"\\"}]},dollars:{inline:[{name:"math_inline_double",rex:/\${2}([^$]*?[^\\])\${2}/gy,tmpl:"<section><eqn>$1</eqn></section>",tag:"$$",displayMode:!0,pre:texmath.$_pre,post:texmath.$_post},{name:"math_inline",rex:/\$((?:[^\s\\])|(?:\S.*?[^\s\\]))\$/gy,tmpl:"<eq>$1</eq>",tag:"$",outerSpace:!1,pre:texmath.$_pre,post:texmath.$_post}],block:[{name:"math_block_eqno",rex:/\${2}([^$]*?[^\\])\${2}\s*?\(([^)\s]+?)\)/gmy,tmpl:'<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',tag:"$$"},{name:"math_block",rex:/\${2}([^$]*?[^\\])\${2}/gmy,tmpl:"<section><eqn>$1</eqn></section>",tag:"$$"}]}};
        // from morphdom@2.7.2
        {let e,t=11,l=(e,l)=>{let n,i,r,d,o,a=l.attributes;if(l.nodeType===t||e.nodeType===t)return;for(let t=a.length-1;t>=0;t--)n=a[t],i=n.name,r=n.namespaceURI,d=n.value,r?(i=n.localName||i,o=e.getAttributeNS(r,i),o!==d&&("xmlns"===n.prefix&&(i=n.name),e.setAttributeNS(r,i,d))):(o=e.getAttribute(i),o!==d&&e.setAttribute(i,d));let u=e.attributes;for(let t=u.length-1;t>=0;t--)n=u[t],i=n.name,r=n.namespaceURI,r?(i=n.localName||i,l.hasAttributeNS(r,i)||e.removeAttributeNS(r,i)):l.hasAttribute(i)||e.removeAttribute(i)},n="http://www.w3.org/1999/xhtml",i="undefined"==typeof document?void 0:document,r=!!i&&"content"in i.createElement("template"),d=!!i&&i.createRange&&"createContextualFragment"in i.createRange(),o=e=>{let t=i.createElement("template");return t.innerHTML=e,t.content.childNodes[0]},a=t=>(e||(e=i.createRange(),e.selectNode(i.body)),e.createContextualFragment(t).childNodes[0]),u=e=>{let t=i.createElement("body");return t.innerHTML=e,t.childNodes[0]},s=e=>(e=e.trim(),r?o(e):d?a(e):u(e)),f=(e,t)=>{let l,n,i=e.nodeName,r=t.nodeName;return i===r||(l=i.charCodeAt(0),n=r.charCodeAt(0),l<=90&&n>=97?i===r.toUpperCase():n<=90&&l>=97&&r===i.toUpperCase())},c=(e,t)=>t&&t!==n?i.createElementNS(t,e):i.createElement(e),m=(e,t)=>{let l=e.firstChild;for(;l;){let e=l.nextSibling;t.appendChild(l),l=e}return t},p=(e,t,l)=>{e[l]!==t[l]&&(e[l]=t[l],e[l]?e.setAttribute(l,""):e.removeAttribute(l))},h={OPTION:(e,t)=>{let l=e.parentNode;if(l){let n=l.nodeName.toUpperCase();"OPTGROUP"===n&&(l=l.parentNode,n=l&&l.nodeName.toUpperCase()),"SELECT"!==n||l.hasAttribute("multiple")||(e.hasAttribute("selected")&&!t.selected&&(e.setAttribute("selected","selected"),e.removeAttribute("selected")),l.selectedIndex=-1)}p(e,t,"selected")},INPUT:(e,t)=>{p(e,t,"checked"),p(e,t,"disabled"),e.value!==t.value&&(e.value=t.value),t.hasAttribute("value")||e.removeAttribute("value")},TEXTAREA:(e,t)=>{let l=t.value;e.value!==l&&(e.value=l);let n=e.firstChild;if(n){let t=n.nodeValue;if(t==l||!l&&t==e.placeholder)return;n.nodeValue=l}},SELECT:(e,t)=>{if(!t.hasAttribute("multiple")){let t,l,n=-1,i=0,r=e.firstChild;for(;r;)if(l=r.nodeName&&r.nodeName.toUpperCase(),"OPTGROUP"===l)t=r,r=t.firstChild;else{if("OPTION"===l){if(r.hasAttribute("selected")){n=i;break}i++}r=r.nextSibling,!r&&t&&(r=t.nextSibling,t=null)}e.selectedIndex=n}}},N=1,b=11,A=3,C=8,T=()=>{},g=e=>{if(e)return e.getAttribute&&e.getAttribute("id")||e.id},E=e=>function(t,l,n){if(n||(n={}),"string"==typeof l)if("#document"===t.nodeName||"HTML"===t.nodeName||"BODY"===t.nodeName){let e=l;(l=i.createElement("html")).innerHTML=e}else l=s(l);else l.nodeType===b&&(l=l.firstElementChild);let r=n.getNodeKey||g,d=n.onBeforeNodeAdded||T,o=n.onNodeAdded||T,a=n.onBeforeElUpdated||T,u=n.onElUpdated||T,p=n.onBeforeNodeDiscarded||T,E=n.onNodeDiscarded||T,v=n.onBeforeElChildrenUpdated||T,x=n.skipFromChildren||T,y=n.addChild||function(e,t){return e.appendChild(t)},S=!0===n.childrenOnly,U=Object.create(null),O=[],R=e=>{O.push(e)},V=(e,t)=>{if(e.nodeType===N){let l=e.firstChild;for(;l;){let e;t&&(e=r(l))?R(e):(E(l),l.firstChild&&V(l,t)),l=l.nextSibling}}},w=(e,t,l)=>{!1!==p(e)&&(t&&t.removeChild(e),E(e),V(e,l))},I=e=>{if(e.nodeType===N||e.nodeType===b){let t=e.firstChild;for(;t;){let e=r(t);e&&(U[e]=t),I(t),t=t.nextSibling}}};I(t);let P=e=>{o(e);let t=e.firstChild;for(;t;){let e=t.nextSibling,l=r(t);if(l){let e=U[l];e&&f(t,e)?(t.parentNode.replaceChild(e,t),B(e,t)):P(t)}else P(t);t=e}},B=(t,l,n)=>{let i=r(l);if(i&&delete U[i],!n){if(!1===a(t,l))return;if(e(t,l),u(t),!1===v(t,l))return}"TEXTAREA"!==t.nodeName?L(t,l):h.TEXTAREA(t,l)},L=(e,t)=>{let l,n,o,a,u,s=x(e,t),c=t.firstChild,m=e.firstChild;e:for(;c;){for(a=c.nextSibling,l=r(c);!s&&m;){if(o=m.nextSibling,c.isEqualNode&&c.isEqualNode(m)){c=a,m=o;continue e}n=r(m);let t,i=m.nodeType;if(i===c.nodeType&&(i===N?(l?l!==n&&((u=U[l])?o===u?t=!1:(e.insertBefore(u,m),n?R(n):w(m,e,!0),m=u,n=r(m)):t=!1):n&&(t=!1),t=!1!==t&&f(m,c),t&&B(m,c)):i!==A&&i!=C||(t=!0,m.nodeValue!==c.nodeValue&&(m.nodeValue=c.nodeValue))),t){c=a,m=o;continue e}n?R(n):w(m,e,!0),m=o}if(l&&(u=U[l])&&f(u,c))s||y(e,u),B(u,c);else{let t=d(c);!1!==t&&(t&&(c=t),c.actualize&&(c=c.actualize(e.ownerDocument||i)),y(e,c),P(c))}c=a,m=o}((e,t,l)=>{for(;t;){let n=t.nextSibling;(l=r(t))?R(l):w(t,e,!0),t=n}})(e,m,n);let p=h[e.nodeName];p&&p(e,t)},D=t,z=D.nodeType,H=l.nodeType;if(!S)if(z===N)H===N?f(t,l)||(E(t),D=m(t,c(l.nodeName,l.namespaceURI))):D=l;else if(z===A||z===C){if(H===z)return D.nodeValue!==l.nodeValue&&(D.nodeValue=l.nodeValue),D;D=l}if(B(D,l,S),O)for(let e=0,t=O.length;e<t;e++){let t=U[O[e]];t&&w(t,t.parentNode,!1)}return!S&&D!==t&&t.parentNode&&(D.actualize&&(D=D.actualize(t.ownerDocument||i)),t.parentNode.replaceChild(D,t)),D};window.morphdom=E(l)};   
        // from sha1-uint8array@0.10.7
        {const K=[1518500249,1859775393,-1894007588,-899497514];window.createHash=()=>new Hash;class Hash{constructor(){this.A=1732584193,this.B=-271733879,this.C=-1732584194,this.D=271733878,this.E=-1009589776,this._size=0,this._sp=0,(!sharedBuffer||sharedOffset>=8e3)&&(sharedBuffer=new ArrayBuffer(8e3),sharedOffset=0),this._byte=new Uint8Array(sharedBuffer,sharedOffset,80),this._word=new Int32Array(sharedBuffer,sharedOffset,20),sharedOffset+=80};update(t){if("string"==typeof t)return this._utf8(t);if(null==t)throw new TypeError("Invalid type: "+typeof t);const s=t.byteOffset,e=t.byteLength;let r=e/64|0,i=0;if(r&&!(3&s)&&!(this._size%64)){const e=new Int32Array(t.buffer,s,16*r);for(;r--;)this._int32(e,i>>2),i+=64;this._size+=i}if(1!==t.BYTES_PER_ELEMENT&&t.buffer){const r=new Uint8Array(t.buffer,s+i,e-i);return this._uint8(r)}return i===e?this:this._uint8(t,i)};_uint8(t,s){const{_byte:e,_word:r}=this,i=t.length;for(s|=0;s<i;){const h=this._size%64;let n=h;for(;s<i&&n<64;)e[n++]=t[s++];n>=64&&this._int32(r),this._size+=n-h}return this};_utf8(t){const{_byte:s,_word:e}=this,r=t.length;let i=this._sp;for(let h=0;h<r;){const n=this._size%64;let f=n;for(;h<r&&f<64;){let e=0|t.charCodeAt(h++);e<128?s[f++]=e:e<2048?(s[f++]=192|e>>>6,s[f++]=128|63&e):e<55296||e>57343?(s[f++]=224|e>>>12,s[f++]=128|e>>>6&63,s[f++]=128|63&e):i?(e=((1023&i)<<10)+(1023&e)+65536,s[f++]=240|e>>>18,s[f++]=128|e>>>12&63,s[f++]=128|e>>>6&63,s[f++]=128|63&e,i=0):i=e}f>=64&&(this._int32(e),e[0]=e[16]),this._size+=f-n}return this._sp=i,this};_int32(t,s){let{A:e,B:r,C:i,D:h,E:n}=this,f=0;for(s|=0;f<16;)W[f++]=swap32(t[s++]);for(f=16;f<80;f++)W[f]=rotate1(W[f-3]^W[f-8]^W[f-14]^W[f-16]);for(f=0;f<80;f++){const t=f/20|0,s=rotate5(e)+ft(t,r,i,h)+n+W[f]+K[t]|0;n=h,h=i,i=rotate30(r),r=e,e=s}this.A=e+this.A|0,this.B=r+this.B|0,this.C=i+this.C|0,this.D=h+this.D|0,this.E=n+this.E|0};digest(t){const{_byte:s,_word:e}=this;let r=this._size%64|0;for(s[r++]=128;3&r;)s[r++]=0;if(r>>=2,r>14){for(;r<16;)e[r++]=0;r=0,this._int32(e)}for(;r<16;)e[r++]=0;const i=8*this._size,h=(4294967295&i)>>>0,n=(i-h)/4294967296;return n&&(e[14]=swap32(n)),h&&(e[15]=swap32(h)),this._int32(e),"hex"===t?this._hex():this._bin()};_hex(){const{A:t,B:s,C:e,D:r,E:i}=this;return hex32(t)+hex32(s)+hex32(e)+hex32(r)+hex32(i)};_bin(){const{A:t,B:s,C:e,D:r,E:i,_byte:h,_word:n}=this;return n[0]=swap32(t),n[1]=swap32(s),n[2]=swap32(e),n[3]=swap32(r),n[4]=swap32(i),h.slice(0,20)}};const W=new Int32Array(80);let sharedBuffer,sharedOffset=0;const hex32=t=>(t+4294967296).toString(16).substr(-8),swapLE=t=>t<<24&4278190080|t<<8&16711680|t>>8&65280|t>>24&255,swapBE=t=>t,swap32=isBE()?swapBE:swapLE,rotate1=t=>t<<1|t>>>31,rotate5=t=>t<<5|t>>>27,rotate30=t=>t<<30|t>>>2;function ft(t,s,e,r){return 0===t?s&e|~s&r:2===t?s&e|s&r|e&r:s^e^r}function isBE(){return 254===new Uint8Array(new Uint16Array([65279]).buffer)[0]}};

        const stringToArray = string => {
            let arr = []
            for (let i = 0; i < string.length; i++) {
                arr.push(string.charCodeAt(i));
            }
            return arr
        }
        const stringToUint = string => {
            return new Uint8Array(stringToArray(string));
        }
        const uintToString = uintArray => {
            let str = "";
            let len = Math.ceil(uintArray.byteLength / 32767);
            for (let i = 0; i < len; i++) {
                str += String.fromCharCode.apply(null, uintArray.subarray(i * 32767, Math.min((i + 1) * 32767, uintArray.byteLength)));
            }
            return str;
        }
        let isCompressedChats = localStorage.getItem("compressedChats") === "true";
        const originSetItem = localStorage.setItem;
        localStorage.setItem = (key, value) => {
            try {
                if (isCompressedChats && key === "chats") value = uintToString(deflateSync(new TextEncoder().encode(value), { level: 1 }));
                originSetItem.call(localStorage, key, value)
            } catch (e) {
                if (isCompressedChats) {
                    notyf.error(translations[locale]["localQuotaExceedTip"])
                    return;
                }
                let isKeyChats = key === "chats";
                let compressed = uintToString(deflateSync(new TextEncoder().encode(isKeyChats ? value : localStorage.getItem("chats")), { level: 1 }));
                originSetItem.call(localStorage, "chats", compressed);
                originSetItem.call(localStorage, "compressedChats", true);
                isCompressedChats = true;
                if (!isKeyChats) originSetItem.call(localStorage, key, value);
            }
        }

        const localeList = ["en", "zh"];
        let locale; // UI语言
        const setLangEle = document.getElementById("setLang");
        const setLang = () => {
            let langClass = locale + "Lang";
            localStorage.setItem("UILang", locale)
            document.documentElement.lang = locale === "zh" ? "zh-CN" : "en";
            setLangEle.classList = "setDetail themeDetail langDetail " + langClass;
        }
        setLangEle.onclick = (ev) => {
            let idx = Array.prototype.indexOf.call(setLangEle.children, ev.target);
            if (locale !== localeList[idx]) {
                locale = localeList[idx];
                setLang();
                changeLocale();
            }
        }
        const initLang = () => {
            let localLang = localStorage.getItem("UILang") || (navigator.language.startsWith("zh-") ? "zh" : "en");
            let isInit = locale === void 0;
            if (locale !== localLang) {
                locale = localLang;
                if (!isInit) changeLocale();
            };
            setLang();
        }
        initLang();
        const translations = {
            "en": {
                "description": "Simple and powerful ChatGPT app",
                "newChat": "New chat",
                "newChatName": "New chat",
                "newFolder": "New folder",
                "newFolderName": "New folder",
                "search": "Search",
                "matchCaseTip": "Match case",
                "forceRe": "Force refresh",
                "clearAll": "Clear all chats",
                "setting": "Setting",
                "nav": "Navigate",
                "winedWin": "Window",
                "fullWin": "Full screen",
                "quickSet": "Quick setting",
                "chat": "Chat",
                "tts": "TTS",
                "stt": "STT",
                "avatar": "Avatar",
                "systemRole": "System role",
                "presetRole": "Preset",
                "default": "Default",
                "assistant": "Assistant",
                "cat": "Cat girl",
                "emoji": "Emoji",
                "withImg": "Image",
                "defaultText": "",
                "assistantText": "You are a helpful assistant, answer as concisely as possible.",
                "catText": "You are a cute cat girl, you must end every sentence with 'meow'",
                "emojiText": "Your personality is very lively, there must be at least one emoji icon in every sentence",
                "imageText": "When you need to send pictures, please generate them in markdown language, without backslashes or code boxes. When you need to use the unsplash API, follow the format, https://source.unsplash.com/960x640/?<English keywords>",
                "nature": "Nature",
                "natureNeg": "Accurate",
                "naturePos": "Creativity",
                "quality": "Quality",
                "qualityNeg": "Repetitive",
                "qualityPos": "Nonsense",
                "chatsWidth": "Chats width",
                "typeSpeed": "Typing speed",
                "continuousLen": "Context messages",
                "msgAbbr": " msgs.",
                "slow": "Slow",
                "fast": "Fast",
                "longReply": "Long reply",
                "ttsService": "TTS API",
                "sttService": "STT API",
                "openaiTTS": "OpenAI",
                "azureTTS": "Azure",
                "edgeTTS": "Edge",
                "systemTTS": "System",
                "azureRegion": "Azure region",
                "azureKey": "Azure key",
                "loadVoice": "Load voice",
                "voiceName": "Switch",
                "userVoice": "User voice",
                "replyVoice": "Reply voice",
                "TTSTest": "Hello, nice to meet you.",
                "play": "Play",
                "pause": "Pause",
                "resume": "Resume",
                "stop": "Stop",
                "style": "Style",
                "role": "Role",
                "volume": "Volume",
                "low": "Low",
                "high": "High",
                "rate": "Rate",
                "slow": "Slow",
                "fast": "Fast",
                "pitch": "Pitch",
                "neutral": "Neutral",
                "intense": "Intense",
                "contSpeech": "Continuous speech",
                "autoSpeech": "Auto speech",
                "unsupportRecTip": "Voice recognition is not supported in the current environment. Please refer to the documentation.",
                "loadRecVoice": "Load language",
                "lang": "Language",
                "dialect": "Dialect",
                "autoSendKey": "Auto send keyword",
                "autoStopKey": "Auto stop keyword",
                "autoSendDelay": "Auto send delay time",
                "second": "s",
                "keepListenMic": "Keep listen",
                "send": "Send",
                "askTip": "Type message here",
                "clearChat": "Clear chat",
                "general": "General",
                "hotkey": "Hotkey",
                "data": "Data",
                "theme": "Theme",
                "darkTheme": "Dark",
                "lightTheme": "Light",
                "autoWord": "Auto",
                "systemTheme": "System",
                "customDarkTheme": "Custom dark theme",
                "startDark": "Start",
                "endDark": "End",
                "aiEndpoint": " endpoint",
                "aiKey": " API key",
                "aiModel": "Custom model name",
                "used": "Used ",
                "available": "Avail ",
                "navKey": "Toggle nav",
                "fullKey": "Window size",
                "themeKey": "Toggle theme",
                "langKey": "Toggle lang",
                "inputKey": "Message",
                "voiceKey": "Voice",
                "resetTip": "Restore default",
                "recKey": "Recognition",
                "speechKey": "Start speech",
                "export": "Export",
                "import": "Import",
                "clear": "Clear",
                "reset": "Reset",
                "localStore": "Local storage",
                "forceReTip": "Force refresh page?",
                "noSpeechTip": "No speech was detected. You may need to adjust your microphone settings.",
                "noMicTip": "No microphone was found. Ensure that a microphone is installed and microphone settings are configured correctly.",
                "noMicPerTip": "Permission to use microphone is blocked.",
                "azureInvalidTip": "Invalid access key or wrong Azure region endpoint, please check!",
                "errorAiKeyTip": "Invalid or incorrect API key, please check API key!",
                "copyCode": "Copy code",
                "copySuccess": "Success",
                "update": "Update",
                "cancel": "Cancel",
                "delMsgTip": "Delete this message?",
                "edit": "Edit",
                "refresh": "Refresh",
                "continue": "Continue",
                "copy": "Copy",
                "del": "Delete",
                "downAudio": "Download audio",
                "speech": "Speech",
                "chats": " chats",
                "delFolderTip": "Delete this folder?",
                "delChatTip": "Delete this chat?",
                "exportSuccTip": "Export successful!",
                "importSuccTip": "Import successful!",
                "importFailTip": "Import failed, please check the file format!",
                "clearChatSuccTip": "Clear chats data successful!",
                "resetSetSuccTip": "Reset settings successful!",
                "clearAllTip": "Delete all chats and folders?",
                "resetSetTip": "Restore all settings to default?",
                "hotkeyConflict": "Hotkey conflict, please choose another key!",
                "customDarkTip": "Start time and end time cannot be the same!",
                "timeoutTip": "Request timeout, please try again later!",
                "largeReqTip": "Request is too large, please delete part of the chat or cancel continuous chat!",
                "noModelPerTip": "Not permission to use this model, please choose another GPT model!",
                "apiRateTip": "Trigger API call rate limit, please try again later!",
                "exceedLimitTip": "API usage exceeded limit, please check your bill!",
                "badGateTip": "Gateway error or timeout, please try again later!",
                "badEndpointTip": "Failed to access the endpoint, please check the endpoint!",
                "clearChatTip": "Clear this chat?",
                "cantSpeechTip": "Current voice cannot synthesize this message, please choose another voice or message!",
                "cantTranscribeTip": "Voice recognition failed, please try again!",
                "noStreamTip": "Automatic features aren't available for non-realtime speech recognition service!",
                "localQuotaExceedTip": "Local storage exceeded limit, please export chats data and clear or delete some chats!",
            },
            "zh": {
                "description": "简洁而强大的ChatGPT应用",
                "newChat": "新建会话",
                "newChatName": "新的会话",
                "newFolder": "新建文件夹",
                "newFolderName": "新文件夹",
                "search": "搜索",
                "matchCaseTip": "区分大小写",
                "forceRe": "强制刷新",
                "clearAll": "清空全部",
                "setting": "设置",
                "nav": "导航",
                "winedWin": "窗口",
                "fullWin": "全屏",
                "quickSet": "快速设置",
                "chat": "会话",
                "tts": "语音合成",
                "stt": "语音识别",
                "avatar": "用户头像",
                "systemRole": "系统角色",
                "presetRole": "预设角色",
                "default": "默认",
                "assistant": "助手",
                "cat": "猫娘",
                "emoji": "表情",
                "withImg": "有图",
                "defaultText": "",
                "assistantText": "你是一个乐于助人的助手，尽量简明扼要地回答",
                "catText": "你是一个可爱的猫娘，每句话结尾都要带个'喵'",
                "emojiText": "你的性格很活泼，每句话中都要有至少一个emoji图标",
                "imageText": "当你需要发送图片的时候，请用 markdown 语言生成，不要反斜线，不要代码框，需要使用 unsplash API时，遵循一下格式， https://source.unsplash.com/960x640/? ＜英文关键词＞",
                "nature": "角色性格",
                "natureNeg": "准确严谨",
                "naturePos": "灵活创新",
                "quality": "回答质量",
                "qualityNeg": "重复保守",
                "qualityPos": "胡言乱语",
                "chatsWidth": "会话宽度",
                "typeSpeed": "打字机速度",
                "continuousLen": "上下文消息数",
                "msgAbbr": "条",
                "slow": "慢",
                "fast": "快",
                "longReply": "长回复",
                "ttsService": "语音合成服务",
                "sttService": "语音识别服务",
                "openaiTTS": "OpenAI语音",
                "azureTTS": "Azure语音",
                "edgeTTS": "Edge语音",
                "systemTTS": "系统语音",
                "azureRegion": "Azure区域",
                "azureKey": "Azure密钥",
                "loadVoice": "加载语音",
                "voiceName": "切换",
                "userVoice": "用户语音",
                "replyVoice": "回答语音",
                "TTSTest": "你好，很高兴认识你。",
                "play": "播放",
                "pause": "暂停",
                "resume": "恢复",
                "stop": "停止",
                "style": "风格",
                "role": "角色",
                "volume": "音量",
                "low": "低",
                "high": "高",
                "rate": "语速",
                "slow": "慢",
                "fast": "快",
                "pitch": "音调",
                "neutral": "平淡",
                "intense": "起伏",
                "contSpeech": "连续朗读",
                "autoSpeech": "自动朗读",
                "unsupportRecTip": "当前环境不支持语音识别，请查阅文档。",
                "loadRecVoice": "加载语言",
                "lang": "语言",
                "dialect": "方言",
                "autoSendKey": "自动发送关键词",
                "autoStopKey": "自动停止关键词",
                "autoSendDelay": "自动发送延迟时间",
                "second": "秒",
                "keepListenMic": "保持监听",
                "send": "发送",
                "askTip": "来问点什么吧",
                "clearChat": "清空会话",
                "general": "通用",
                "hotkey": "快捷键",
                "data": "数据",
                "theme": "主题",
                "darkTheme": "深色",
                "lightTheme": "浅色",
                "autoWord": "自动",
                "systemTheme": "跟随系统",
                "customDarkTheme": "自定义深色主题时间",
                "startDark": "开始时间",
                "endDark": "结束时间",
                "aiEndpoint": "接口",
                "aiKey": "API密钥",
                "aiModel": "自定义模型",
                "used": "已用 ",
                "available": "可用 ",
                "navKey": "切换导航",
                "fullKey": "全屏/窗口",
                "themeKey": "切换主题",
                "langKey": "切换语言",
                "inputKey": "输入框",
                "voiceKey": "语音",
                "resetTip": "重置设置",
                "recKey": "语音输入",
                "speechKey": "朗读会话",
                "export": "导出",
                "import": "导入",
                "clear": "清空",
                "reset": "重置",
                "localStore": "本地存储",
                "forceReTip": "是否强制刷新页面？",
                "noSpeechTip": "未识别到语音，请调整麦克风后重试！",
                "noMicTip": "未识别到麦克风，请确保已安装麦克风！",
                "noMicPerTip": "未允许麦克风权限！",
                "azureInvalidTip": "Azure区域错误或密钥无效，请检查！",
                "errorAiKeyTip": "API密钥错误或失效，请检查API密钥！",
                "copyCode": "复制代码",
                "copySuccess": "复制成功",
                "update": "更新",
                "cancel": "取消",
                "delMsgTip": "是否删除此消息？",
                "edit": "编辑",
                "refresh": "刷新",
                "continue": "继续",
                "copy": "复制",
                "del": "删除",
                "downAudio": "下载语音",
                "speech": "朗读",
                "chats": "个会话",
                "delFolderTip": "是否删除此文件夹？",
                "delChatTip": "是否删除此会话？",
                "exportSuccTip": "导出成功！",
                "importSuccTip": "导入成功！",
                "importFailTip": "导入失败，请检查文件格式！",
                "clearChatSuccTip": "清空会话成功！",
                "resetSetSuccTip": "重置设置成功！",
                "clearAllTip": "是否删除所有会话和文件夹？",
                "resetSetTip": "是否还原所有设置为默认值？",
                "hotkeyConflict": "快捷键冲突，请选择其他键位！",
                "customDarkTip": "开始时间和结束时间不能相同！",
                "timeoutTip": "请求超时，请稍后重试！",
                "largeReqTip": "请求内容过大，请删除部分对话或关闭连续对话！",
                "noModelPerTip": "无权使用此模型，请选择其他GPT模型！",
                "apiRateTip": "触发API调用频率限制，请稍后重试！",
                "exceedLimitTip": "API使用超出限额，请检查您的账单！",
                "badGateTip": "网关错误或超时，请稍后重试！",
                "badEndpointTip": "访问接口失败，请检查接口！",
                "clearChatTip": "是否清空此会话？",
                "cantSpeechTip": "当前语音无法合成此消息，请选择其他语音或消息！",
                "cantTranscribeTip": "语音识别失败，请重试！",
                "noStreamTip": "非实时语音识别服务无法使用自动功能！",
                "localQuotaExceedTip": "本地存储超出限额，请导出会话并清空或删除部分会话！",
            },
        };
        const translateElement = (ele, type) => {
            const key = ele.getAttribute("data-i18n-" + type);
            const translation = translations[locale][key];
            if (type === "title") {
                ele.setAttribute("title", translation);
            } else if (type === "place") {
                ele.setAttribute("placeholder", translation);
            } else if (type === "value") {
                ele.setAttribute("value", translation);
            } else {
                ele.textContent = translation;
            }
        }
        const initLocale = () => {
            document.querySelectorAll("[data-i18n-title]").forEach(ele => { translateElement(ele, "title") });
            document.querySelectorAll("[data-i18n-place]").forEach(ele => { translateElement(ele, "place") });
            document.querySelectorAll("[data-i18n-value]").forEach(ele => { translateElement(ele, "value") });
            document.querySelectorAll("[data-i18n-key]").forEach(ele => { translateElement(ele, "key") });
            document.querySelectorAll("[data-i18n-theme]").forEach(ele => {
                let key = themeMode === 2 ? "autoWord" : themeMode === 1 ? "lightTheme" : "darkTheme";
                ele.setAttribute("title", translations[locale][key])
            })
            document.querySelectorAll("[data-i18n-window]").forEach(ele => {
                let key = isFull ? "winedWin" : "fullWin";
                ele.setAttribute("title", translations[locale][key])
            })
            document.head.children[3].setAttribute("content", translations[locale]["description"])
        };
        initLocale();
        const changeLocale = () => {
            initLocale();
            document.querySelectorAll("[data-type='chatEdit'],[data-type='folderEdit']").forEach(ele => {
                ele.children[0].textContent = translations[locale]["edit"];
            });
            document.querySelectorAll("[data-type='chatDel'],[data-type='folderDel']").forEach(ele => {
                ele.children[0].textContent = translations[locale]["del"];
            });
            document.querySelectorAll("[data-type='folderAddChat']").forEach(ele => {
                ele.children[0].textContent = translations[locale]["newChat"];
            });
            document.querySelectorAll("[data-id]").forEach(ele => {
                let key = ele.getAttribute("data-id");
                if (key.endsWith("Md")) {
                    if (key === "speechMd" || key === "pauseMd" || key === "resumeMd") {
                        ele.children[0].textContent = translations[locale][key.slice(0, -2)];
                    } else if (key === "refreshMd") {
                        ele.setAttribute("title", translations[locale][ele.classList.contains("refreshReq") ? "refresh" : "continue"]);
                    } else {
                        ele.setAttribute("title", translations[locale][key.slice(0, -2)]);
                    }
                }
            });
            document.querySelectorAll(".folderNum").forEach(ele => {
                let num = ele.textContent.match(/\d+/)[0];
                ele.textContent = num + translations[locale]["chats"];
            });
            document.querySelectorAll(".u-mdic-copy-btn").forEach(ele => {
                ele.setAttribute("text", translations[locale]["copyCode"]);
            })
            document.querySelectorAll(".u-mdic-copy-notify").forEach(ele => {
                ele.setAttribute("text", translations[locale]["copySuccess"]);
            })
            if (editingIdx !== void 0) {
                document.querySelector("[data-i18n-key='send']").textContent = translations[locale]["update"];
                document.querySelector("[data-i18n-title='clearChat']").setAttribute("title", translations[locale]["cancel"]);
            }
            loadPrompt();
        }

        const windowEle = document.getElementsByClassName("chat_window")[0];
        const messagesEle = document.getElementsByClassName("messages")[0];
        const chatlog = document.getElementById("chatlog");
        const stopEle = document.getElementById("stopChat");
        const sendBtnEle = document.getElementById("sendbutton");
        const clearEle = document.getElementsByClassName("clearConv")[0];
        const inputAreaEle = document.getElementById("chatinput");
        const settingEle = document.getElementById("setting");
        const dialogEle = document.getElementById("setDialog");
        const selectorEle = document.getElementById("selector");
        const modelSetEle = document.getElementById("modelDialog");
        const lightEle = document.getElementById("toggleLight");
        const setLightEle = document.getElementById("setLight");
        const autoThemeEle = document.getElementById("autoDetail");
        const systemEle = document.getElementById("systemInput");
        const speechServiceEle = document.getElementById("preSetService");
        const recServiceEle = document.getElementById("preRecService");
        const newChatEle = document.getElementById("newChat");
        const folderListEle = document.getElementById("folderList");
        const chatListEle = document.getElementById("chatList");
        const searchChatEle = document.getElementById("searchChat");
        const voiceRecEle = document.getElementById("voiceRecIcon");
        const voiceRecSetEle = document.getElementById("voiceRecSetting");
        const preEle = document.getElementById("preSetSystem");
        let voicesData; // 语音数据
        let voiceType = 1; // 设置 0: 提问语音，1：回答语音
        let voiceRole = []; // 语音
        let voiceTestText; // 测试语音文本
        let voiceVolume = []; //音量
        let voiceRate = []; // 语速
        let voicePitch = []; // 音调
        let enableContVoice; // 连续朗读
        let enableAutoVoice; // 自动朗读
        let existVoice = 2; // 4:OpenAI语音 3:Azure语音 2:edge在线语音, 1:本地语音, 0:不支持语音
        const azureRegions = ['southafricanorth', 'eastasia', 'southeastasia', 'australiaeast', 'centralindia', 'japaneast', 'japanwest', 'koreacentral', 'canadacentral', 'northeurope', 'westeurope', 'francecentral', 'germanywestcentral', 'norwayeast', 'swedencentral', 'switzerlandnorth', 'switzerlandwest', 'uksouth', 'uaenorth', 'brazilsouth', 'qatarcentral', 'centralus', 'eastus', 'eastus2', 'northcentralus', 'southcentralus', 'westcentralus', 'westus', 'westus2', 'westus3'];
        let azureRegion;
        let azureKey;
        let azureRole = [];
        let azureStyle = [];
        const supportSpe = !!(window.speechSynthesis && window.SpeechSynthesisUtterance);
        const isSafeEnv = window.isSecureContext; // 安全上下文
        const supportLocalRec = isSafeEnv && !!window.webkitSpeechRecognition; // 是否支持本地语音识别输入
        const supportOnlineRec = isSafeEnv && navigator.mediaDevices && navigator.mediaDevices.getUserMedia && window.AudioContext && ("audioWorklet" in window.AudioContext.prototype || "createScriptProcessor" in window.AudioContext.prototype);
        const supportOnlineLegacyRec = isSafeEnv && navigator.mediaDevices && navigator.mediaDevices.getUserMedia && !!window.MediaRecorder && (MediaRecorder.isTypeSupported("audio/webm") || MediaRecorder.isTypeSupported("audio/mp4"));
        const supportRec = supportLocalRec || supportOnlineRec || supportOnlineLegacyRec;
        let existRec = 1; // 2:Azure语音，1:系统语音
        let azureRecRegion;
        let azureRecKey;
        let recing = false;
        let autoSendWord; // 自动发送关键词
        let autoStopWord; // 自动停止关键词
        let autoSendTime; // 自动发送延迟时间
        let keepListenMic; // 保持监听麦克风
        let autoSendTimer;
        let resetRecRes;
        let toggleRecEv;
        const isAndroid = /\bAndroid\b/i.test(navigator.userAgent);
        const isApple = /(Mac|iPhone|iPod|iPad)/i.test(navigator.userAgent);
        const isSafari = /Safari/.test(navigator.userAgent) && !/Chrome/.test(navigator.userAgent);
        const isPWA = navigator.standalone || window.matchMedia("(display-mode: standalone)").matches;
        if (isPWA) {
            let bottomEle = document.querySelector(".bottom_wrapper");
            let footerEle = document.querySelector(".navFooter");
            footerEle.style.marginBottom = bottomEle.style.marginBottom = "8px";
        };
        const dayMs = 8.64e7;
        refreshPage.onclick = () => {
            if (confirmAction(translations[locale]["forceReTip"])) {
                location.href = location.origin + location.pathname + "?" + new Date().getTime()
            }
        };
        const noLoading = () => {
            return !loading && (!currentResEle || currentResEle.dataset.loading !== "true")
        };
        const uuidv4 = (upper) => {
            let uuid = ([1e7] + 1e3 + 4e3 + 8e3 + 1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
            return upper ? uuid.toUpperCase() : uuid;
        };
        if (!isMobile) inputAreaEle.focus();
        const textInputEvent = () => {
            if (noLoading()) sendBtnEle.classList.toggle("activeSendBtn", inputAreaEle.value.trim().length);
            inputAreaEle.style.height = "47px";
            inputAreaEle.style.height = inputAreaEle.scrollHeight + "px";
        };
        inputAreaEle.oninput = textInputEvent;
        const toggleNavEv = () => {
            let isShowNav = document.body.classList.toggle("show-nav");
            if (window.innerWidth > 800) {
                localStorage.setItem("pinNav", isShowNav)
            }
        }
        document.body.addEventListener("mousedown", event => {
            if (event.target.className === "toggler") {
                toggleNavEv();
            } else if (event.target.className === "overlay") {
                document.body.classList.remove("show-nav");
            } else if (event.target === document.body) {
                if (window.innerWidth <= 800) {
                    document.body.classList.remove("show-nav");
                }
            }
        });
        const endSetEvent = (ev) => {
            if (!document.getElementById("sysDialog").contains(ev.target)) {
                ev.preventDefault();
                ev.stopPropagation();
                endSet();
            }
        }
        const endSet = () => {
            document.getElementById("sysMask").style.display = "none";
            document.body.removeEventListener("click", endSetEvent, true);
        }
        document.getElementById("closeSet").onclick = endSet;
        document.getElementById("sysSetting").onclick = () => {
            document.getElementById("sysMask").style.display = "flex";
            checkStorage();
            document.getElementById("sysMask").onmousedown = endSetEvent;
        };
        const setAutoTimer = () => {
            if (autoSendTime) {
                autoSendTimer = setTimeout(() => {
                    genFunc();
                    autoSendTimer = void 0;
                }, autoSendTime * 1000);
            }
        }
        const clearAutoSendTimer = () => {
            if (autoSendTimer !== void 0) {
                clearTimeout(autoSendTimer);
                autoSendTimer = void 0;
            }
        }
        if (!supportLocalRec) recServiceEle.remove(2);
        if (!supportOnlineRec) recServiceEle.remove(1);
        if (!supportOnlineLegacyRec) recServiceEle.remove(0);
        const initRecVal = () => {
            if (!supportRec) {
                noRecTip.style.display = "block"
                noRecTip.parentElement.firstElementChild.style.display = "none";
                noRecTip.parentElement.children[1].style.display = "none";
                return;
            }
            let localRecType = localStorage.getItem("existRec");
            recServiceEle.value = existRec = parseInt(localRecType || (supportLocalRec ? "1" : "2"));
        }
        initRecVal();
        const clearAzureRec = () => {
            azureRecKey = void 0;
            localStorage.removeItem(azureRecRegion + "RecData");
            azureRecData = void 0;
            azureRecRegion = void 0;
            azureRecKeyInput.parentElement.style.display = "none";
            preRecAzureRegion.parentElement.style.display = "none";
        }
        const featStreamRec = (hide) => {
            document.querySelectorAll('[data-feat="forStream"]').forEach(item => item.style.display = (hide ? "none" : "block"))
            document.querySelectorAll('[data-feat="forNoStream"]').forEach(item => item.style.display = (hide ? "block" : "none"))
        }
        let azureRecData, systemRecData, checkAzureRecAbort;
        const toggleRecCheck = (bool) => {
            checkRecLoad.style.display = bool ? "flex" : "none";
            recDetail.style.display = bool ? "none" : "block";
            hotKeyVoiceRec.parentElement.style.display = bool ? "none" : "block";
            document.getElementById("voiceRec").style.display = bool ? "none" : "block";
            if (bool) inputAreaEle.classList.remove("message_if_voice");
            else inputAreaEle.classList.add("message_if_voice");
        }
        recServiceEle.onchange = () => {
            if (!supportRec) return;
            existRec = parseInt(recServiceEle.value);
            localStorage.setItem("existRec", existRec);
            toggleRecCheck(true);
            if (checkAzureRecAbort && !checkAzureRecAbort.signal.aborted) {
                checkAzureRecAbort.abort();
                checkAzureRecAbort = void 0;
            }
            if (existRec === 3) {
                clearAzureRec();
                loadOpenAIRec();
                featStreamRec(true);
            } else if (existRec === 2) {
                azureRecKeyInput.parentElement.style.display = "block";
                preRecAzureRegion.parentElement.style.display = "block";
                loadAzureRec();
                featStreamRec();
            } else {
                clearAzureRec();
                loadLocalRec();
                featStreamRec();
            }
        }
        const loadLocalRec = () => { initRecSetting() };
        const loadOpenAIRec = () => { initRecSetting() };
        const loadAzureRec = () => {
            let checking = false;
            const checkAzureFunc = () => {
                if (checking) return;
                if (azureRecKey) {
                    checking = true;
                    checkRecLoad.classList.add("voiceChecking");
                    checkAzureRecAbort = new AbortController();
                    setTimeout(() => {
                        if (checkAzureRecAbort && !checkAzureRecAbort.signal.aborted) {
                            checkAzureRecAbort.abort();
                            checkAzureRecAbort = void 0;
                        }
                    }, 15000);
                    getAzureToken(checkAzureRecAbort.signal).then(() => {
                        getRecList(checkAzureRecAbort.signal).then(() => {
                            initRecSetting(azureRecData);
                        }).catch(e => {
                        }).finally(() => {
                            checkRecLoad.classList.remove("voiceChecking");
                            checking = false;
                        })
                    }).catch(e => {
                    }).finally(() => {
                        checkRecLoad.classList.remove("voiceChecking");
                        checking = false;
                    })
                }
            };
            checkRecLoad.onclick = checkAzureFunc;
            const getAzureToken = (signal) => {
                return new Promise((res, rej) => {
                    fetch("https://" + azureRecRegion + ".api.cognitive.microsoft.com/sts/v1.0/issueToken", {
                        signal,
                        method: "POST",
                        headers: {
                            "Ocp-Apim-Subscription-Key": azureRecKey
                        }
                    }).then(response => {
                        response.text().then(text => {
                            try {
                                let json = JSON.parse(text);
                                notyf.error(translations[locale]["azureInvalidTip"]);
                                rej();
                            } catch (e) {
                                res();
                            }
                        });
                    }).catch(e => {
                        localStorage.removeItem(azureRecRegion + "RecData");
                        azureRecData = void 0;
                        rej();
                    })
                })
            };
            const getRecList = (signal) => {
                return new Promise((res, rej) => {
                    if (azureRecData) res();
                    else {
                        let localAzureRecData = localStorage.getItem(azureRecRegion + "RecData");
                        if (localAzureRecData) {
                            azureRecData = JSON.parse(localAzureRecData);
                            res();
                        } else {
                            fetch("https://" + azureRecRegion + ".stt.speech.microsoft.com/api/v1.0/languages/recognition", {
                                signal
                            }).then(response => {
                                response.json().then(json => {
                                    azureRecData = json;
                                    localStorage.setItem(azureRecRegion + "RecData", JSON.stringify(json));
                                    res();
                                }).catch(e => {
                                    notyf.error(translations[locale]["azureInvalidTip"]);
                                    rej();
                                })
                            }).catch(e => {
                                localStorage.removeItem(azureRecRegion + "RecData");
                                azureRecData = void 0;
                                rej();
                            })
                        }
                    }
                })
            };
            let azureRecRegionEle = document.getElementById("preRecAzureRegion");
            if (!azureRecRegionEle.options.length) {
                azureRegions.forEach((region, i) => {
                    let option = document.createElement("option");
                    option.value = region;
                    option.text = region;
                    azureRecRegionEle.options.add(option);
                });
            }
            let localAzureRecRegion = localStorage.getItem("azureRecRegion");
            if (localAzureRecRegion) {
                azureRecRegion = localAzureRecRegion;
                azureRecRegionEle.value = localAzureRecRegion;
            }
            azureRecRegionEle.onchange = () => {
                azureRecRegion = azureRecRegionEle.value;
                localStorage.setItem("azureRecRegion", azureRecRegion);
                toggleRecCheck(true);
            }
            azureRecRegionEle.dispatchEvent(new Event("change"));
            let azureRecKeyEle = document.getElementById("azureRecKeyInput");
            let localAzureRecKey = localStorage.getItem("azureRecKey");
            if (localAzureRecKey) {
                azureRecKey = localAzureRecKey;
                azureRecKeyEle.value = localAzureRecKey;
            }
            azureRecKeyEle.onchange = () => {
                azureRecKey = azureRecKeyEle.value;
                localStorage.setItem("azureRecKey", azureRecKey);
                toggleRecCheck(true);
            }
            azureRecKeyEle.dispatchEvent(new Event("change"));
            if (azureRecKey) checkAzureFunc();
        }
        const azureLangTrans = { "en-au": "Australia", "en-ca": "Canada", "en-gb": "United Kingdom", "en-gh": "Ghana", "en-hk": "Hong Kong SAR", "en-ie": "Ireland", "en-in": "India", "en-ke": "Kenya", "en-ng": "Nigeria", "en-nz": "New Zealand", "en-ph": "Philippines", "en-sg": "Singapore", "en-tz": "Tanzania", "en-us": "United States", "en-za": "South Africa", "nan-cn": "闽南语，简体", "wuu-cn": "吴语，简体", "yue-cn": "粤语，简体", "zh-cn": "普通话，简体", "zh-cn-anhui": "安徽江淮普通话，简体", "zh-cn-bilingual": "普通话，英语双语", "zh-cn-gansu": "甘肃兰银普通话，简体", "zh-cn-guangxi": "广西口音普通话，简体", "zh-cn-henan": "中原官话河南，简体", "zh-cn-hunan": "湖南口音普通话，简体", "zh-cn-liaoning": "东北官话，简体", "zh-cn-shaanxi": "中原官话陕西，简体", "zh-cn-shandong": "冀鲁官话，简体", "zh-cn-shanxi": "山西口音普通话，简体", "zh-cn-sichuan": "西南官话，简体", "zh-hk": "粤语，繁体", "zh-sg": "简体，新加坡", "zh-tw": "台湾普通话" };
        const initRecSetting = (azureData) => {
            let langs = [['中文'], ['English']];
            if (azureData) {
                azureData.forEach(item => {
                    if (item.startsWith("en-")) {
                        let lowCase = item.toLowerCase();
                        let dialectName = azureLangTrans[lowCase] || lowCase;
                        if (lowCase == "en-us") langs[1].splice(1, 0, [lowCase, dialectName]);
                        else langs[1].push([lowCase, dialectName]);
                    } else if (item.indexOf("CN") != -1 || item.indexOf("zh") != -1) {
                        let lowCase = item.toLowerCase();
                        let dialectName = azureLangTrans[lowCase] || lowCase;
                        if (lowCase == "zh-cn") langs[0].splice(1, 0, [lowCase, dialectName]);
                        else langs[0].push([lowCase, dialectName]);
                    }
                })
            } else if (existRec === 3) {
                langs = [
                    ['自动检测', ['', '自动检测']],
                    ['中文', ['zh', '汉语']],
                    ['English', ['en', 'English']]
                ];
            } else {
                langs = [ // from https://www.google.com/intl/en/chrome/demos/speech.html
                    ['中文', ['cmn-Hans-CN', '普通话 (大陆)'],
                        ['cmn-Hans-HK', '普通话 (香港)'],
                        ['cmn-Hant-TW', '中文 (台灣)'],
                        ['yue-Hant-HK', '粵語 (香港)']],
                    ['English', ['en-US', 'United States'],
                        ['en-GB', 'United Kingdom'],
                        ['en-AU', 'Australia'],
                        ['en-CA', 'Canada'],
                        ['en-IN', 'India'],
                        ['en-KE', 'Kenya'],
                        ['en-TZ', 'Tanzania'],
                        ['en-GH', 'Ghana'],
                        ['en-NZ', 'New Zealand'],
                        ['en-NG', 'Nigeria'],
                        ['en-ZA', 'South Africa'],
                        ['en-PH', 'Philippines']]
                ];
            };
            toggleRecCheck(false);
            if (locale !== "zh") {
                if (existRec === 3) {
                    langs[0][0] = langs[0][1][1] = translations[locale]["autoWord"];
                    let idx = langs.findIndex((item) => { return item[1][0] === locale });
                    let [temp] = langs.splice(idx, 1);
                    langs.splice(1, 0, temp);
                } else langs = langs.reverse();
            }
            selectLangOption.options.length = select_language.options.length = 0;
            langs.forEach((lang, i) => {
                select_language.options.add(new Option(lang[0], i));
                selectLangOption.options.add(new Option(lang[0], i))
            });
            const updateCountry = function () {
                selectLangOption.selectedIndex = select_language.selectedIndex = this.selectedIndex;
                select_dialect.innerHTML = "";
                selectDiaOption.innerHTML = "";
                let list = langs[select_language.selectedIndex];
                for (let i = 1; i < list.length; i++) {
                    select_dialect.options.add(new Option(list[i][1], list[i][0]));
                    selectDiaOption.options.add(new Option(list[i][1], list[i][0]));
                }
                select_dialect.style.visibility = list[1].length == 1 ? "hidden" : "visible";
                selectDiaOption.parentElement.style.visibility = list[1].length == 1 ? "hidden" : "visible";
                localStorage.setItem("voiceRecLang", select_dialect.value);
            };
            let localLangIdx = 0;
            let localDiaIdx = 0;
            let localRecLang = localStorage.getItem("voiceRecLang") || langs[0][1][0];
            if (localRecLang) {
                let localIndex = langs.findIndex(item => {
                    let diaIdx = item.findIndex(lang => { return lang instanceof Array && lang[0] === localRecLang });
                    if (diaIdx !== -1) {
                        localDiaIdx = diaIdx - 1;
                        return true;
                    }
                    return false;
                });
                if (localIndex !== -1) localLangIdx = localIndex;
            }
            selectLangOption.onchange = updateCountry;
            select_language.onchange = updateCountry;
            selectDiaOption.onchange = select_dialect.onchange = function () {
                selectDiaOption.selectedIndex = select_dialect.selectedIndex = this.selectedIndex;
                localStorage.setItem("voiceRecLang", select_dialect.value);
            }
            selectLangOption.selectedIndex = select_language.selectedIndex = localLangIdx;
            select_language.dispatchEvent(new Event("change"));
            selectDiaOption.selectedIndex = select_dialect.selectedIndex = localDiaIdx;
            select_dialect.dispatchEvent(new Event("change"));
            initRecEvent();
        };
        let recSetTimer;
        let initRecFunc = () => {
            if (!supportRec) return;
            let localAutoSendWord = localStorage.getItem("autoVoiceSendWord");
            autoSendWord = autoSendText.value = localAutoSendWord || autoSendText.getAttribute("value") || "";
            autoSendText.onchange = () => {
                autoSendWord = autoSendText.value;
                localStorage.setItem("autoVoiceSendWord", autoSendWord);
            }
            autoSendText.dispatchEvent(new Event("change"));
            let localAutoStopWord = localStorage.getItem("autoVoiceStopWord");
            autoStopWord = autoStopText.value = localAutoStopWord || autoStopText.getAttribute("value") || "";
            autoStopText.onchange = () => {
                autoStopWord = autoStopText.value;
                localStorage.setItem("autoVoiceStopWord", autoStopWord);
            }
            autoStopText.dispatchEvent(new Event("change"));
            let outEle = document.getElementById("autoSendTimeout");
            let localTimeout = localStorage.getItem("autoVoiceSendOut");
            outEle.value = autoSendTime = parseInt(localTimeout || outEle.getAttribute("value"));
            outEle.oninput = () => {
                outEle.style.backgroundSize = (outEle.value - outEle.min) * 100 / (outEle.max - outEle.min) + "% 100%";
                autoSendTime = parseInt(outEle.value);
                localStorage.setItem("autoVoiceSendOut", outEle.value);
            }
            outEle.dispatchEvent(new Event("input"));
            outEle.onchange = () => {
                let hasAutoTimer = !!autoSendTimer;
                clearAutoSendTimer();
                if (hasAutoTimer) setAutoTimer();
            }
            const keepMicEle = document.getElementById("keepListenMic");
            let localKeepMic = localStorage.getItem("keepListenMic");
            keepMicEle.checked = keepListenMic = (localKeepMic || keepMicEle.getAttribute("checked")) === "true";
            keepMicEle.onchange = () => {
                keepListenMic = keepMicEle.checked;
                localStorage.setItem("keepListenMic", keepListenMic);
            }
            keepMicEle.dispatchEvent(new Event("change"));
            const closeEvent = (ev) => {
                if (voiceRecSetEle.contains(ev.target)) return;
                if (!voiceRecSetEle.contains(ev.target)) {
                    voiceRecSetEle.style.display = "none";
                    document.removeEventListener("mousedown", closeEvent, true);
                    voiceRecEle.classList.remove("voiceLong");
                }
            }
            const longEvent = () => {
                voiceRecSetEle.style.display = "block";
                document.addEventListener("mousedown", closeEvent, true);
            }
            const voiceDownEvent = (ev) => {
                ev.preventDefault();
                let i = 0;
                voiceRecEle.classList.add("voiceLong");
                recSetTimer = setInterval(() => {
                    i += 1;
                    if (i >= 3) {
                        clearInterval(recSetTimer);
                        recSetTimer = void 0;
                        longEvent();
                    }
                }, 100)
            }
            const voiceUpEvent = (ev) => {
                ev.preventDefault();
                if (recSetTimer !== void 0) {
                    toggleRecEv();
                    clearInterval(recSetTimer);
                    recSetTimer = void 0;
                    voiceRecEle.classList.remove("voiceLong");
                }
            }
            voiceRecEle.onmouseup = voiceUpEvent;
            voiceRecEle.ontouchend = voiceUpEvent;
            voiceRecEle.onmousedown = voiceDownEvent;
            voiceRecEle.ontouchstart = voiceDownEvent;
        }
        initRecFunc();
        class RiffPcmEncoder {
            constructor(actualSampleRate, desiredSampleRate) {
                this.privActualSampleRate = actualSampleRate;
                this.privDesiredSampleRate = desiredSampleRate;
            }
            encode(actualAudioFrame) {
                const audioFrame = this.downSampleAudioFrame(actualAudioFrame, this.privActualSampleRate, this.privDesiredSampleRate);
                if (!audioFrame) return null;
                const audioLength = audioFrame.length * 2;
                const buffer = new ArrayBuffer(audioLength);
                const view = new DataView(buffer);
                this.floatTo16BitPCM(view, 0, audioFrame);
                return buffer;
            }
            floatTo16BitPCM(view, offset, input) {
                for (let i = 0; i < input.length; i++, offset += 2) {
                    const s = Math.max(-1, Math.min(1, input[i]));
                    view.setInt16(offset, s < 0 ? s * 0x8000 : s * 0x7FFF, true);
                }
            }
            downSampleAudioFrame(srcFrame, srcRate, dstRate) {
                if (!srcFrame) return null;
                if (dstRate === srcRate || dstRate > srcRate) return srcFrame;
                const ratio = srcRate / dstRate;
                const dstLength = Math.round(srcFrame.length / ratio);
                const dstFrame = new Float32Array(dstLength);
                let srcOffset = 0;
                let dstOffset = 0;
                while (dstOffset < dstLength) {
                    const nextSrcOffset = Math.round((dstOffset + 1) * ratio);
                    let accum = 0;
                    let count = 0;
                    while (srcOffset < nextSrcOffset && srcOffset < srcFrame.length) {
                        accum += srcFrame[srcOffset++];
                        count++;
                    }
                    dstFrame[dstOffset++] = accum / count;
                }
                return dstFrame;
            }
        }
        let recSocket;
        class Recorder {
            constructor() {
                this.ready = false;
                this.connId = "";
                this.reqId = "";
                this.label = "";
                this.processScriptURL = "";
                this.forceStop = false;
                this.sampleRate = 16000;
                // avgBytesPerSec / 10, 0.1s
                this.bufferSize = this.sampleRate / 5;
                this.chunks = [];
                this.chunksByte = 0;
                // "Content-Type: audio/x-wav\r\n" + WAV header
                this.wavHeader = new Uint8Array([67, 111, 110, 116, 101, 110, 116, 45, 84, 121, 112, 101, 58, 32, 97, 117, 100, 105, 111, 47, 120, 45, 119, 97, 118, 13, 10, 82, 73, 70, 70, 0, 0, 0, 0, 87, 65, 86, 69, 102, 109, 116, 32, 16, 0, 0, 0, 1, 0, 1, 0, 128, 62, 0, 0, 0, 125, 0, 0, 2, 0, 16, 0, 100, 97, 116, 97, 0, 0, 0, 0])
            }
            initRecorder() {
                return new Promise((res) => {
                    // microsoft cognitive-services-speech-sdk-js
                    this.context = navigator.mediaDevices.getSupportedConstraints().sampleRate ? new AudioContext({ sampleRate: this.sampleRate }) : new AudioContext();
                    this.audioInput = this.context.createMediaStreamSource(this.stream);
                    if (this.context.audioWorklet) {
                        if (this.processScriptURL == "") {
                            const workletScript = `${RiffPcmEncoder.toString()}
                            class SP extends AudioWorkletProcessor {
                            constructor(options) {
                                super(options);
                                this.sampleRate = ${this.sampleRate};
                                // avgBytesPerSec / 10, 0.1s
                                this.bufferSize = ${this.bufferSize};
                                this.encoder = new RiffPcmEncoder(options.processorOptions.sampleRate, this.sampleRate);
                                this.chunks = [];
                                this.chunksByte = 0;
                                this.processing = true;
                                this.port.onmessage = (e) => {
                                if (e.data === "stop") {
                                    this.processing = false;
                                    this.port.close();
                                }
                                }
                            }
                            concat() {
                                let result = new Uint8Array(this.bufferSize);
                                let offset = 0;
                                for (let i = 0; i < this.chunks.length; i++) {
                                result.set(this.chunks[i], offset);
                                offset += this.chunks[i].byteLength;
                                }
                                return result;
                            }
                            process(inputs) {
                                if (inputs[0][0]) {
                                let data = new Uint8Array(this.encoder.encode(inputs[0][0]));
                                this.chunks.push(data);
                                this.chunksByte += data.byteLength;
                                if (this.chunksByte > this.bufferSize) {
                                    let lastChunk = this.chunks[this.chunks.length - 1];
                                    this.chunks[this.chunks.length - 1] = lastChunk.subarray(0, lastChunk.byteLength - this.chunksByte + this.bufferSize);
                                    let chunk = this.concat();
                                    this.port.postMessage(chunk, [chunk.buffer]);
                                    this.chunks.length = 0;
                                    this.chunks.push(lastChunk.subarray(lastChunk.byteLength - this.chunksByte + this.bufferSize));
                                    this.chunksByte = this.chunks[0].byteLength;
                                } else if (this.chunksByte === this.bufferSize) {
                                    let chunk = this.concat();
                                    this.port.postMessage(chunk, [chunk.buffer]);
                                    this.chunks.length = this.chunksByte = 0;
                                }
                                }
                                return this.processing;
                            }
                            }
                            registerProcessor('speech-processor', SP);`;
                            this.processScriptURL = URL.createObjectURL(new Blob([workletScript], { type: "application/javascript; charset=utf-8" }));
                        }
                        this.context.audioWorklet.addModule(this.processScriptURL).then(() => {
                            this.recorder = new AudioWorkletNode(this.context, "speech-processor", {
                                processorOptions: { sampleRate: this.context.sampleRate }
                            });
                            this.ready = true;
                            this.recorder.port.onmessage = (e) => { if (e.data && this.ready) recSocket.send(this.getRecBin(e.data)) };
                            if (isFirefox) { // tested firefox need volume gain
                                this.gain = this.context.createGain();
                                this.gain.gain.value = 3;
                                this.audioInput.connect(this.gain);
                                this.gain.connect(this.recorder);
                            } else this.audioInput.connect(this.recorder);
                            this.recorder.connect(this.context.destination);
                            res();
                        }).catch(e => { this.attachScriptProcessor(res) })
                    } else this.attachScriptProcessor(res);
                })
            }
            attachScriptProcessor(res) {
                this.encoder = new RiffPcmEncoder(this.context.sampleRate, this.sampleRate);
                this.recorder = (() => {
                    let bufferSize = 0;
                    try {
                        return this.context.createScriptProcessor(bufferSize, 1, 1);
                    } catch (error) {
                        // Webkit (<= version 31) requires a valid bufferSize.
                        bufferSize = 2048;
                        let audioSampleRate = this.context.sampleRate;
                        while (bufferSize < 16384 && audioSampleRate >= (this.audioInput.channelCount * this.sampleRate)) {
                            bufferSize <<= 1;
                            audioSampleRate >>= 1;
                        }
                        return this.context.createScriptProcessor(bufferSize, 1, 1);
                    }
                })();
                this.ready = true;
                this.recorder.onaudioprocess = (event) => {
                    const inputFrame = event.inputBuffer.getChannelData(0);
                    if (inputFrame && this.ready) this.pushWSFrame(new Uint8Array(this.encoder.encode(inputFrame)));
                };
                if (isFirefox) { // tested firefox need volume gain
                    this.gain = this.context.createGain();
                    this.gain.gain.value = 3;
                    this.audioInput.connect(this.gain);
                    this.gain.connect(this.recorder);
                } else this.audioInput.connect(this.recorder);
                this.recorder.connect(this.context.destination);
                res();
            }
            pushWSFrame(audio) {
                let totalByte = this.chunksByte + audio.byteLength;
                if (totalByte >= this.bufferSize) {
                    let offset = 0;
                    for (let i = 0; i < Math.floor(totalByte / this.bufferSize); i++) {
                        if (this.chunksByte) {
                            let partAudio = audio.subarray(offset, (i + 1) * this.bufferSize - this.chunksByte);
                            this.chunks.push(partAudio);
                            let chunk = this.concat();
                            recSocket.send(this.getRecBin(chunk));
                            offset = (i + 1) * this.bufferSize - this.chunksByte;
                            this.chunks.length = this.chunksByte = 0;
                        } else {
                            let partAudio = audio.subarray(offset, offset + this.bufferSize);
                            recSocket.send(this.getRecBin(partAudio));
                            offset += this.bufferSize;
                        }
                    }
                    if (offset < audio.byteLength) {
                        this.chunks.push(audio.subarray(offset));
                        this.chunksByte = this.chunks[0].byteLength;
                    }
                } else {
                    this.chunks.push(audio);
                    this.chunksByte += audio.byteLength;
                }
            }
            concat() {
                let result = new Uint8Array(this.bufferSize);
                let offset = 0;
                for (let i = 0; i < this.chunks.length; i++) {
                    result.set(this.chunks[i], offset);
                    offset += this.chunks[i].byteLength;
                }
                return result;
            }
            initRecWebsocket() {
                return new Promise((res, rej) => {
                    let url = `wss://${azureRecRegion}.stt.speech.microsoft.com/speech/recognition/conversation/cognitiveservices/v1?Ocp-Apim-Subscription-Key=${azureRecKey}&language=${select_dialect.value}&storeAudio=true`;
                    if (!recSocket || recSocket.readyState > 1 || recSocket.url.slice(0, -48) !== url) {
                        if (recSocket && recSocket.readyState === 1) recSocket.close(1000);
                        recSocket = new WebSocket(url + `&X-ConnectionId=${this.connId}`);
                        recSocket.binaryType = "arraybuffer";
                        recSocket.onopen = () => { res() };
                        recSocket.onmessage = (e) => { this.handleWSMsg(e) };
                        recSocket.onerror = (e) => {
                            if (!this.ready) notyf.error(translations[locale]["badGateTip"]);
                            recSocket.close();
                            rej();
                        };
                        recSocket.onclose = (e) => {
                            if (this.ready) {
                                this.ready = false;
                                this.retryWebsocket(recSocket.url)
                            }
                        }
                    } else {
                        return res()
                    }
                })
            }
            retryWebsocket(url) {
                recSocket = new WebSocket(url);
                recSocket.binaryType = "arraybuffer";
                recSocket.onopen = () => {
                    this.startWSDetect();
                    this.ready = true;
                }
                recSocket.onmessage = (e) => { this.handleWSMsg(e) };
                recSocket.onerror = (e) => { recSocket.close() };
                recSocket.onclose = (e) => {
                    notyf.error(translations[locale]["badGateTip"]);
                    this.stopRecorder(true);
                }
            }
            handleWSMsg(e) {
                if (typeof e.data === "string") {
                    let path = e.data.match(/Path:(.+)/)[1].trim();
                    let splitData = e.data.split("\n");
                    if (this.ready && (path === "speech.phrase" || path === "speech.hypothesis")) {
                        let data = JSON.parse(splitData[splitData.length - 1]);
                        let isFinal = data.DisplayText !== void 0;
                        let autoFlag;
                        if (isFinal) {
                            recRes += data.DisplayText;
                            if (autoSendWord) {
                                let idx = recRes.indexOf(autoSendWord);
                                if (idx !== -1) {
                                    recRes = recRes.slice(0, idx);
                                    autoFlag = 1;
                                }
                            }
                            if (autoStopWord) {
                                let idx = recRes.indexOf(autoStopWord);
                                if (idx !== -1) {
                                    recRes = recRes.slice(0, idx);
                                    autoFlag = 2;
                                }
                            }
                        }
                        else if (data.Text) { tempRes = recRes + data.Text }
                        inputAreaEle.value = preRes + (isFinal ? recRes : tempRes) + affRes;
                        textInputEvent();
                        inputAreaEle.focus();
                        inputAreaEle.selectionEnd = inputAreaEle.value.length - affRes.length;
                        if (autoFlag) {
                            if (autoFlag === 1) genFunc();
                            else this.stopRecorder(true);
                        }
                        clearAutoSendTimer();
                        if (autoFlag !== 1) setAutoTimer();
                    } else if (path === "turn.end") {
                        if (!this.forceStop && keepListenMic || this.ready) {
                            this.startWSDetect();
                            this.ready = true;
                        }
                    }
                }
            }
            startWSDetect() {
                this.reqId = uuidv4(true);
                recSocket.send(this.getRecPre(this.label));
                recSocket.send(this.getRecConfig());
                recSocket.send(this.getRecPreBin());
            }
            getRecPre(label) {
                let osPlatform = (typeof window !== "undefined") ? "Browser" : "Node";
                osPlatform += "/" + navigator.platform;
                let osName = navigator.userAgent;
                let osVersion = navigator.appVersion;
                return `Path: speech.config\r\nX-RequestId: ${this.reqId}\r\nX-Timestamp: ${new Date().toISOString()}\r\nContent-Type: application/json\r\n\r\n{"context":{"system":{"name":"SpeechSDK","version":"1.35.0","build":"JavaScript","lang":"JavaScript"},"os":{"platform":"${osPlatform}","name":"${osName}","version":"${osVersion}"},"audio":{"source":{"bitspersample":16,"channelcount":1,"connectivity":"Unknown","manufacturer":"Speech SDK","model":"${label}","samplerate":${this.sampleRate},"type":"Microphones"}}},"recognition":"conversation"}`
            }
            getRecConfig() {
                return `Path: speech.context\r\nX-RequestId: ${this.reqId}\r\nX-Timestamp: ${new Date().toISOString()}\r\nContent-Type: application/json\r\n\r\n{"phraseDetection":{}}`
            }
            getRecPreBin() {
                let header = this.getRecHeader();
                let data = new Uint8Array(2 + header.length + this.wavHeader.byteLength);
                data.set([0, 126], 0);
                data.set(stringToArray(header), 2);
                data.set(this.wavHeader, 2 + header.length);
                return data
            }
            getRecBin(audio) {
                let header = this.getRecHeader();
                let data = new Uint8Array(2 + header.length + audio.byteLength);
                data.set([0, 99], 0);
                data.set(stringToArray(header), 2);
                data.set(audio, 2 + header.length);
                return data
            }
            getRecHeader() {
                return `Path: audio\r\nX-RequestId: ${this.reqId}\r\nX-Timestamp: ${new Date().toISOString()}\r\n`
            }
            getMedia() {
                return new Promise((res, rej) => {
                    navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
                        this.stream = stream;
                        res();
                    }).catch(e => {
                        notyf.error(translations[locale][e.name === "NotAllowedError" ? "noMicPerTip" : "noMicTip"]);
                        rej();
                    })
                })
            }
            async startRecorder() {
                return new Promise((res, rej) => {
                    this.connId = uuidv4(true);
                    Promise.all([this.getMedia(), this.initRecWebsocket()]).then((val) => {
                        this.label = this.stream.getAudioTracks()[0].label;
                        this.startWSDetect();
                        this.initRecorder().then(() => { res() });
                    }).catch(e => {
                        if (this.stream) {
                            this.stream.getAudioTracks().forEach(track => { track.stop() });
                            this.stream = null;
                        }
                        rej(e);
                    })
                })
            }
            stopRecWebsocket() {
                if (recSocket && recSocket.readyState === 1) {
                    let endBin = this.getRecBin(new Uint8Array());
                    recSocket.send(endBin);
                    recSocket.send(endBin);
                }
            }
            stopRecorder(forceStop) {
                this.forceStop = forceStop;
                this.ready = false;
                this.stopRecWebsocket();
                clearAutoSendTimer();
                if (!forceStop && keepListenMic) return;
                voiceRecEle.classList.remove("voiceRecing");
                recing = false;
                if (this.recorder && this.recorder.port) {
                    this.recorder.port.postMessage("stop");
                    this.recorder.port.close();
                }
                if (this.stream) {
                    this.stream.getAudioTracks().forEach(track => { track.stop() });
                    this.stream = null;
                }
                if (this.audioInput) {
                    this.audioInput.disconnect();
                    this.audioInput = null;
                }
                if (isFirefox && this.gain) {
                    this.gain.disconnect();
                    this.gain = null;
                }
                if (this.recorder) {
                    this.recorder.disconnect();
                    this.recorder = null;
                }
                if (this.context) {
                    this.context.close();
                    this.context = null;
                }
            }
        }
        class LegacyRecorder {
            constructor() {
                this.mimeType = MediaRecorder.isTypeSupported("audio/mp4") ? "audio/mp4" : "audio/webm";
                this.suffix = this.mimeType === "audio/mp4" ? ".mp4" : ".webm";
                this.bitsPerSecond = 128000;
                this.chunks = [];
            }
            initRecorder() {
                this.recorder = new MediaRecorder(this.stream, { mimeType: this.mimeType, audioBitsPerSecond: this.bitsPerSecond });
                this.chunks.length = 0;
                this.recorder.ondataavailable = e => { this.chunks.push(e.data) };
                this.recorder.start(1e3);
            }
            async processData(blob) {
                let formData = new FormData();
                formData.append("model", "whisper-1");
                formData.append("file", blob, "audio" + this.suffix);
                if (select_dialect.value !== "") formData.append("language", select_dialect.value);
                let url = apiHost + ((apiHost.length && !apiHost.endsWith("/")) ? "/" : "") + "v1/audio/transcriptions";
                let controller = new AbortController();
                let controllerId = setTimeout(() => {
                    notyf.error(translations[locale]["timeoutTip"]);
                    controller.abort();
                }, 15000);
                try {
                    const res = await fetch(url, {
                        method: "POST",
                        body: formData,
                        signal: controller.signal,
                        ...(customAPIKey ? { headers: { Authorization: "Bearer " + customAPIKey } } : {})
                    });
                    clearTimeout(controllerId);
                    if (res.status === 200) {
                        let result = await res.json();
                        if (result && result.text) {
                            inputAreaEle.value = preRes + result.text + affRes;
                            textInputEvent();
                            inputAreaEle.focus();
                            inputAreaEle.selectionEnd = inputAreaEle.value.length - affRes.length;
                            return true;
                        }
                    } else notyf.open({ type: "warning", message: translations[locale]["cantTranscribeTip"] });
                } catch (e) { }
            }
            getMedia() {
                return new Promise((res, rej) => {
                    navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
                        this.stream = stream;
                        res();
                    }).catch(e => {
                        notyf.error(translations[locale][e.name === "NotAllowedError" ? "noMicPerTip" : "noMicTip"]);
                        rej(e);
                    })
                })
            }
            async startRecorder() {
                return new Promise((res, rej) => {
                    this.getMedia().then(() => {
                        this.initRecorder();
                        res();
                    }).catch(e => { rej(e) })
                })
            }
            stopRecorder(forceStop) {
                return new Promise((res, rej) => {
                    clearAutoSendTimer();
                    if (this.recorder && this.recorder.state === "recording") {
                        this.recorder.onstop = async (e) => {
                            let blob = new Blob(this.chunks, { type: this.mimeType });
                            this.chunks.length = 0;
                            try {
                                let result = await this.processData(blob);
                                if (result) res();
                                else rej();
                            } catch (error) { rej() };
                            if (!forceStop && keepListenMic) this.recorder.start(1e3);
                        };
                        this.recorder.stop();
                    } else res();
                    if (!forceStop && keepListenMic) return;
                    voiceRecEle.classList.remove("voiceRecing");
                    recing = false;
                    if (this.recorder) this.recorder = null;
                    if (this.stream) {
                        this.stream.getAudioTracks().forEach(track => { track.stop() });
                        this.stream = null;
                    }
                })
            }
        }
        let recorder, legacyRecorder, initingRecorder;
        let recRes = tempRes = "";
        let preRes, affRes;
        resetRecRes = () => {
            preRes = inputAreaEle.value.slice(0, inputAreaEle.selectionStart);
            affRes = inputAreaEle.value.slice(inputAreaEle.selectionEnd);
            recRes = tempRes = "";
        }
        const initRecEvent = () => {
            if (existRec === 3) {
                if (legacyRecorder === void 0) legacyRecorder = new LegacyRecorder();
                toggleRecEv = async (force = true) => {
                    if (voiceRecEle.classList.contains("voiceRecing")) await legacyRecorder.stopRecorder(force);
                    else {
                        if (initingRecorder) return;
                        resetRecRes();
                        initingRecorder = true;
                        legacyRecorder.startRecorder().then(() => {
                            recing = true;
                            initingRecorder = false;
                            voiceRecEle.classList.add("voiceRecing");
                        }).catch(e => {
                            legacyRecorder.stopRecorder(force);
                            initingRecorder = false;
                        })
                    }
                }
            } else if (existRec === 2) {
                if (recorder === void 0) recorder = new Recorder();
                toggleRecEv = (force = true) => {
                    if (voiceRecEle.classList.contains("voiceRecing")) recorder.stopRecorder(force);
                    else {
                        if (initingRecorder) return;
                        resetRecRes();
                        initingRecorder = true;
                        recorder.startRecorder().then(() => {
                            recing = true;
                            initingRecorder = false;
                            voiceRecEle.classList.add("voiceRecing");
                        }).catch(e => {
                            recorder.stopRecorder(force)
                            initingRecorder = false;
                        })
                    }
                }
            } else {
                let recIns = new webkitSpeechRecognition();
                // prevent some Android bug
                recIns.continuous = !isAndroid;
                recIns.interimResults = true;
                recIns.maxAlternatives = 1;
                let resEvent = (event) => {
                    if (typeof (event.results) === "undefined") {
                        toggleRecEv();
                        return;
                    }
                    let isFinal;
                    let autoFlag;
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        isFinal = event.results[i].isFinal;
                        if (isFinal) {
                            recRes += event.results[i][0].transcript
                            if (autoSendWord) {
                                let idx = recRes.indexOf(autoSendWord);
                                if (idx !== -1) {
                                    recRes = recRes.slice(0, idx);
                                    autoFlag = 1;
                                    break;
                                }
                            }
                            if (autoStopWord) {
                                let idx = recRes.indexOf(autoStopWord);
                                if (idx !== -1) {
                                    recRes = recRes.slice(0, idx);
                                    autoFlag = 2;
                                    break;
                                }
                            }
                        }
                        else { tempRes = recRes + event.results[i][0].transcript }
                    }
                    inputAreaEle.value = preRes + (isFinal ? recRes : tempRes) + affRes;
                    textInputEvent();
                    inputAreaEle.focus();
                    inputAreaEle.selectionEnd = inputAreaEle.value.length - affRes.length;
                    if (autoFlag) {
                        if (autoFlag === 1) genFunc();
                        else endEvent(false, false);
                    }
                    clearAutoSendTimer();
                    if (autoFlag !== 1) setAutoTimer();
                };
                const stopAction = () => {
                    clearAutoSendTimer();
                    recIns.onresult = null;
                    recIns.onerror = null;
                    recIns.onend = null;
                    voiceRecEle.classList.remove("voiceRecing");
                    recing = false;
                };
                const endEvent = (event, flag) => {
                    if (flag !== void 0) {
                        if (!flag) {
                            recIns.stop();
                            stopAction();
                        }
                    } else if (event) {
                        if (keepListenMic && event.type === "end") {
                            recIns.start();
                            resetRecRes();
                        } else {
                            if (event.type === "error") recIns.stop();
                            stopAction();
                        }
                    }
                };
                const errorEvent = (ev) => {
                    if (event.error === "no-speech") {
                        notyf.open({
                            type: "warning",
                            message: translations[locale]["noSpeechTip"]
                        });
                    }
                    if (event.error === "audio-capture") {
                        notyf.error(translations[locale]["noMicTip"])
                        endEvent(ev);
                    }
                    if (event.error === "not-allowed") {
                        notyf.error(translations[locale]["noMicPerTip"])
                        endEvent(ev);
                    }
                };
                toggleRecEv = () => {
                    if (voiceRecEle.classList.toggle("voiceRecing")) {
                        try {
                            resetRecRes();
                            recIns.lang = select_dialect.value;
                            recIns.start();
                            recIns.onresult = resEvent;
                            recIns.onerror = errorEvent;
                            recIns.onend = endEvent;
                            recing = true;
                        } catch (e) {
                            endEvent(false, false);
                        }
                    } else {
                        endEvent(false, false);
                    }
                };
            }
        }
        recServiceEle.dispatchEvent(new Event("change"));
        document.querySelector(".modelSwitch").onclick = document.querySelector(".sysSwitch").onclick = document.querySelector(".setSwitch").onclick = function (ev) {
            let activeEle = this.getElementsByClassName("activeSwitch")[0];
            if (ev.target !== activeEle) {
                activeEle.classList.remove("activeSwitch");
                ev.target.classList.add("activeSwitch");
                document.getElementById(ev.target.dataset.id).style.display = "block";
                document.getElementById(activeEle.dataset.id).style.display = "none";
            }
        };
        if (!supportSpe) speechServiceEle.remove(3);
        const initVoiceVal = () => {
            let localVoiceType = localStorage.getItem("existVoice");
            speechServiceEle.value = existVoice = parseInt(localVoiceType || "2");
        }
        initVoiceVal();
        const clearAzureVoice = () => {
            azureKey = void 0;
            localStorage.removeItem(azureRegion + "VoiceData");
            azureRegion = void 0;
            azureRole = [];
            azureStyle = [];
            document.getElementById("azureExtra").style.display = "none";
            azureKeyInput.parentElement.style.display = "none";
            preSetAzureRegion.parentElement.style.display = "none";
        }
        speechServiceEle.onchange = () => {
            existVoice = parseInt(speechServiceEle.value);
            localStorage.setItem("existVoice", existVoice);
            toggleVoiceCheck(true);
            if (checkAzureAbort && !checkAzureAbort.signal.aborted) {
                checkAzureAbort.abort();
                checkAzureAbort = void 0;
            }
            if (checkEdgeAbort && !checkEdgeAbort.signal.aborted) {
                checkEdgeAbort.abort();
                checkEdgeAbort = void 0;
            }
            if (existVoice === 4) {
                toggleVoiceCheck(false);
                clearAzureVoice();
                loadOpenAIVoice();
            } else if (existVoice === 3) {
                azureKeyInput.parentElement.style.display = "block";
                preSetAzureRegion.parentElement.style.display = "block";
                loadAzureVoice();
            } else if (existVoice === 2) {
                clearAzureVoice();
                loadEdgeVoice();
            } else if (existVoice === 1) {
                toggleVoiceCheck(false);
                clearAzureVoice();
                loadLocalVoice();
            }
        }
        let openaiVoiceData, edgeVoiceData, systemVoiceData, checkAzureAbort, checkEdgeAbort;
        const toggleVoiceCheck = (bool) => {
            checkVoiceLoad.style.display = bool ? "flex" : "none";
            speechDetail.style.display = bool ? "none" : "block";
        }
        const loadOpenAIVoice = () => {
            if (openaiVoiceData) {
                initVoiceSetting(openaiVoiceData);
            } else {
                openaiVoiceData = [{ name: "alloy", displayName: "alloy" }, { name: "echo", displayName: "echo" }, { name: "fable", displayName: "fable" }, { name: "onyx", displayName: "onyx" }, { name: "nova", displayName: "nova" }, { name: "shimmer", displayName: "shimmer" }]
                initVoiceSetting(openaiVoiceData);
            }
        };
        const loadAzureVoice = () => {
            let checking = false;
            const checkAzureFunc = () => {
                if (checking) return;
                if (azureKey) {
                    checking = true;
                    checkVoiceLoad.classList.add("voiceChecking");
                    checkAzureAbort = new AbortController();
                    setTimeout(() => {
                        if (checkAzureAbort && !checkAzureAbort.signal.aborted) {
                            checkAzureAbort.abort();
                            checkAzureAbort = void 0;
                        }
                    }, 15000);
                    getAzureToken(checkAzureAbort.signal).then(() => {
                        getVoiceList(checkAzureAbort.signal).then(() => {
                            toggleVoiceCheck(false);
                        }).catch(e => {
                        }).finally(() => {
                            checkVoiceLoad.classList.remove("voiceChecking");
                            checking = false;
                        })
                    }).catch(e => {
                    }).finally(() => {
                        checkVoiceLoad.classList.remove("voiceChecking");
                        checking = false;
                    })
                }
            };
            checkVoiceLoad.onclick = checkAzureFunc;
            const getAzureToken = (signal) => {
                return new Promise((res, rej) => {
                    fetch("https://" + azureRegion + ".api.cognitive.microsoft.com/sts/v1.0/issueToken", {
                        signal,
                        method: "POST",
                        headers: {
                            "Ocp-Apim-Subscription-Key": azureKey
                        }
                    }).then(response => {
                        response.text().then(text => {
                            try {
                                let json = JSON.parse(text);
                                notyf.error(translations[locale]["azureInvalidTip"]);
                                rej();
                            } catch (e) {
                                res();
                            }
                        });
                    }).catch(e => {
                        localStorage.removeItem(azureRegion + "VoiceData");
                        rej();
                    })
                })
            };
            const getVoiceList = (signal) => {
                return new Promise((res, rej) => {
                    let localAzureVoiceData = localStorage.getItem(azureRegion + "VoiceData");
                    if (localAzureVoiceData) {
                        initVoiceSetting(JSON.parse(localAzureVoiceData));
                        res();
                    } else {
                        fetch("https://" + azureRegion + ".tts.speech.microsoft.com/cognitiveservices/voices/list", {
                            signal,
                            headers: {
                                "Ocp-Apim-Subscription-Key": azureKey
                            }
                        }).then(response => {
                            response.json().then(json => {
                                localStorage.setItem(azureRegion + "VoiceData", JSON.stringify(json));
                                initVoiceSetting(json);
                                res();
                            }).catch(e => {
                                notyf.error(translations[locale]["azureInvalidTip"]);
                                rej();
                            })
                        }).catch(e => {
                            localStorage.removeItem(azureRegion + "VoiceData");
                            rej();
                        })
                    }
                })
            };
            let azureRegionEle = document.getElementById("preSetAzureRegion");
            if (!azureRegionEle.options.length) {
                azureRegions.forEach((region, i) => {
                    let option = document.createElement("option");
                    option.value = region;
                    option.text = region;
                    azureRegionEle.options.add(option);
                });
            }
            let localAzureRegion = localStorage.getItem("azureRegion");
            if (localAzureRegion) {
                azureRegion = localAzureRegion;
                azureRegionEle.value = localAzureRegion;
            }
            azureRegionEle.onchange = () => {
                azureRegion = azureRegionEle.value;
                localStorage.setItem("azureRegion", azureRegion);
                toggleVoiceCheck(true);
            }
            azureRegionEle.dispatchEvent(new Event("change"));
            let azureKeyEle = document.getElementById("azureKeyInput");
            let localAzureKey = localStorage.getItem("azureKey");
            if (localAzureKey) {
                azureKey = localAzureKey;
                azureKeyEle.value = localAzureKey;
            }
            azureKeyEle.onchange = () => {
                azureKey = azureKeyEle.value;
                localStorage.setItem("azureKey", azureKey);
                toggleVoiceCheck(true);
            }
            azureKeyEle.dispatchEvent(new Event("change"));
            if (azureKey) {
                checkAzureFunc();
            }
        }
        const loadEdgeVoice = () => {
            let checking = false;
            const endCheck = () => {
                checkVoiceLoad.classList.remove("voiceChecking");
                checking = false;
            };
            const checkEdgeFunc = () => {
                if (checking) return;
                checking = true;
                checkVoiceLoad.classList.add("voiceChecking");
                if (edgeVoiceData) {
                    initVoiceSetting(edgeVoiceData);
                    toggleVoiceCheck(false);
                    endCheck();
                } else {
                    checkEdgeAbort = new AbortController();
                    setTimeout(() => {
                        if (checkEdgeAbort && !checkEdgeAbort.signal.aborted) {
                            checkEdgeAbort.abort();
                            checkEdgeAbort = void 0;
                        }
                    }, 10000);
                    fetch("https://speech.platform.bing.com/consumer/speech/synthesize/readaloud/voices/list?trustedclienttoken=6A5AA1D4EAFF4E9FB37E23D68491D6F4", { signal: checkEdgeAbort.signal }).then(response => {
                        response.json().then(json => {
                            edgeVoiceData = json;
                            toggleVoiceCheck(false);
                            initVoiceSetting(json);
                            endCheck();
                        });
                    }).catch(err => {
                        endCheck();
                    })
                }
            };
            checkEdgeFunc();
            checkVoiceLoad.onclick = checkEdgeFunc;
        };
        const loadLocalVoice = () => {
            if (systemVoiceData) {
                initVoiceSetting(systemVoiceData);
            } else {
                let initedVoice = false;
                const getLocalVoice = () => {
                    let voices = speechSynthesis.getVoices();
                    if (voices.length) {
                        if (!initedVoice) {
                            initedVoice = true;
                            systemVoiceData = voices;
                            initVoiceSetting(voices);
                        }
                        return true;
                    } else {
                        return false;
                    }
                }
                let syncExist = getLocalVoice();
                if (!syncExist) {
                    if ("onvoiceschanged" in speechSynthesis) {
                        speechSynthesis.onvoiceschanged = () => {
                            getLocalVoice();
                        }
                    } else if (speechSynthesis.addEventListener) {
                        speechSynthesis.addEventListener("voiceschanged", () => {
                            getLocalVoice();
                        })
                    }
                    let timeout = 0;
                    let timer = setInterval(() => {
                        if (getLocalVoice() || timeout > 1000) {
                            if (timeout > 1000) {
                                existVoice = 0;
                            }
                            clearInterval(timer);
                            timer = null;
                        }
                        timeout += 300;
                    }, 300)
                }
            }
        };
        const voicesEle = document.getElementById("preSetSpeech");
        const initVoiceSetting = (voices) => {
            if (existVoice < 4) {
                let isOnline = existVoice === 2 || existVoice === 3;
                // 支持中文和英文
                voices = isOnline ? voices.filter(item => item.Locale.match(/^(zh-|en-)/)) : voices.filter(item => item.lang.match(/^(zh-|en-)/));
                if (isOnline) {
                    voices.map(item => {
                        item.name = item.FriendlyName || (`${item.DisplayName} Online (${item.VoiceType}) - ${item.LocaleName}`);
                        item.lang = item.Locale;
                    })
                } else if (isSafari && voices[0].voiceURI.startsWith("com.apple")) {
                    voices = voices.filter(item => {
                        return !item.voiceURI.startsWith("com.apple.voice.super-compact")
                    })
                }
                voices.sort((a, b) => {
                    if (a.lang.slice(0, 2) === b.lang.slice(0, 2)) {
                        if (a.lang.slice(0, 2) === "zh") {
                            return (a.lang === b.lang) ? 0 : (a.lang > b.lang) ? 1 : -1; // zh-CN 在前
                        } else {
                            return 0
                        }
                    }
                    return (locale === "zh" ? (a.lang < b.lang) : (a.lang > b.lang)) ? 1 : -1; // 中文UI，则中文"z"在前
                });
                voices.map(item => {
                    if (item.name.match(/^(Google |Microsoft )/)) {
                        item.displayName = item.name.replace(/^.*? /, "");
                    } else {
                        item.displayName = item.name;
                    }
                });
                if (isSafari && !isOnline) {
                    voices.map(item => { item.displayName = `${item.name} (${item.lang})` });
                };
            };
            voicesData = voices;
            voicesEle.innerHTML = "";
            voices.forEach((voice, i) => {
                let option = document.createElement("option");
                option.value = i;
                option.text = voice.displayName;
                voicesEle.options.add(option);
            });
            const loadAnother = (type) => {
                type = type ^ 1;
                let localVoice = localStorage.getItem("voice" + type);
                if (localVoice) {
                    let localIndex = voices.findIndex(item => { return item.name === localVoice });
                    if (localIndex === -1) localIndex = 0;
                    voiceRole[type] = voices[localIndex];
                } else {
                    voiceRole[type] = voices[0];
                }
                if (existVoice === 3) {
                    let localStyle = localStorage.getItem("azureStyle" + type);
                    azureStyle[type] = localStyle ? localStyle : void 0;
                    let localRole = localStorage.getItem("azureRole" + type);
                    azureRole[type] = localRole ? localRole : void 0;
                }
            }
            voiceChange();
            loadAnother(voiceType);
        };
        let voiceChange;
        const initVoiceFunc = () => {
            voicesEle.onchange = () => {
                voiceRole[voiceType] = voicesData[voicesEle.value];
                localStorage.setItem("voice" + voiceType, voiceRole[voiceType].name);
                if (voiceRole[voiceType].StyleList || voiceRole[voiceType].RolePlayList) {
                    document.getElementById("azureExtra").style.display = "block";
                    let voiceStyles = voiceRole[voiceType].StyleList;
                    let voiceRoles = voiceRole[voiceType].RolePlayList;
                    if (voiceRoles) {
                        preSetVoiceRole.innerHTML = "";
                        let option = document.createElement("option");
                        option.value = "Default";
                        option.text = "Default";
                        preSetVoiceRole.options.add(option);
                        voiceRoles.forEach((role, i) => {
                            let option = document.createElement("option");
                            option.value = role;
                            option.text = role;
                            preSetVoiceRole.options.add(option);
                        });
                        let localRole = localStorage.getItem("azureRole" + voiceType);
                        if (localRole && voiceRoles.indexOf(localRole) !== -1) {
                            preSetVoiceRole.value = localRole;
                            azureRole[voiceType] = localRole;
                        } else {
                            preSetVoiceRole.selectedIndex = 0;
                            azureRole[voiceType] = voiceRole[0];
                        }
                        preSetVoiceRole.onchange = () => {
                            azureRole[voiceType] = preSetVoiceRole.value;
                            localStorage.setItem("azureRole" + voiceType, preSetVoiceRole.value);
                        }
                        preSetVoiceRole.dispatchEvent(new Event("change"));
                    } else {
                        azureRole[voiceType] = void 0;
                        localStorage.removeItem("azureRole" + voiceType);
                    }
                    preSetVoiceRole.style.display = voiceRoles ? "block" : "none";
                    preSetVoiceRole.previousElementSibling.style.display = voiceRoles ? "block" : "none";
                    if (voiceStyles) {
                        preSetVoiceStyle.innerHTML = "";
                        let option = document.createElement("option");
                        option.value = "Default";
                        option.text = "Default";
                        preSetVoiceStyle.options.add(option);
                        voiceStyles.forEach((style, i) => {
                            let option = document.createElement("option");
                            option.value = style;
                            option.text = style;
                            preSetVoiceStyle.options.add(option);
                        });
                        let localStyle = localStorage.getItem("azureStyle" + voiceType);
                        if (localStyle && voiceStyles.indexOf(localStyle) !== -1) {
                            preSetVoiceStyle.value = localStyle;
                            azureStyle[voiceType] = localStyle;
                        } else {
                            preSetVoiceStyle.selectedIndex = 0;
                            azureStyle[voiceType] = voiceStyles[0];
                        }
                        preSetVoiceStyle.onchange = () => {
                            azureStyle[voiceType] = preSetVoiceStyle.value;
                            localStorage.setItem("azureStyle" + voiceType, preSetVoiceStyle.value)
                        }
                        preSetVoiceStyle.dispatchEvent(new Event("change"));
                    } else {
                        azureStyle[voiceType] = void 0;
                        localStorage.removeItem("azureStyle" + voiceType);
                    }
                    preSetVoiceStyle.style.display = voiceStyles ? "block" : "none";
                    preSetVoiceStyle.previousElementSibling.style.display = voiceStyles ? "block" : "none";
                } else {
                    document.getElementById("azureExtra").style.display = "none";
                    azureRole[voiceType] = void 0;
                    localStorage.removeItem("azureRole" + voiceType);
                    azureStyle[voiceType] = void 0;
                    localStorage.removeItem("azureStyle" + voiceType);
                }
            };
            voiceChange = () => {
                let localVoice = localStorage.getItem("voice" + voiceType);
                if (localVoice) {
                    let localIndex = voicesData.findIndex(item => { return item.name === localVoice });
                    if (localIndex === -1) localIndex = 0;
                    voiceRole[voiceType] = voicesData[localIndex];
                    voicesEle.value = localIndex;
                } else {
                    voiceRole[voiceType] = voicesData[0];
                }
                voicesEle.dispatchEvent(new Event("change"));
            }
            let volumeEle = document.getElementById("voiceVolume");
            let localVolume = localStorage.getItem("voiceVolume0");
            voiceVolume[0] = parseFloat(localVolume || volumeEle.getAttribute("value"));
            const voiceVolumeChange = () => {
                let localVolume = localStorage.getItem("voiceVolume" + voiceType);
                volumeEle.value = voiceVolume[voiceType] = parseFloat(localVolume || volumeEle.getAttribute("value"));
                volumeEle.style.backgroundSize = (volumeEle.value - volumeEle.min) * 100 / (volumeEle.max - volumeEle.min) + "% 100%";
            }
            volumeEle.oninput = () => {
                volumeEle.style.backgroundSize = (volumeEle.value - volumeEle.min) * 100 / (volumeEle.max - volumeEle.min) + "% 100%";
                voiceVolume[voiceType] = parseFloat(volumeEle.value);
                localStorage.setItem("voiceVolume" + voiceType, volumeEle.value);
            }
            voiceVolumeChange();
            let rateEle = document.getElementById("voiceRate");
            let localRate = localStorage.getItem("voiceRate0");
            voiceRate[0] = parseFloat(localRate || rateEle.getAttribute("value"));
            const voiceRateChange = () => {
                let localRate = localStorage.getItem("voiceRate" + voiceType);
                rateEle.value = voiceRate[voiceType] = parseFloat(localRate || rateEle.getAttribute("value"));
                rateEle.style.backgroundSize = (rateEle.value - rateEle.min) * 100 / (rateEle.max - rateEle.min) + "% 100%";
            }
            rateEle.oninput = () => {
                rateEle.style.backgroundSize = (rateEle.value - rateEle.min) * 100 / (rateEle.max - rateEle.min) + "% 100%";
                voiceRate[voiceType] = parseFloat(rateEle.value);
                localStorage.setItem("voiceRate" + voiceType, rateEle.value);
            }
            voiceRateChange();
            let pitchEle = document.getElementById("voicePitch");
            let localPitch = localStorage.getItem("voicePitch0");
            voicePitch[0] = parseFloat(localPitch || pitchEle.getAttribute("value"));
            const voicePitchChange = () => {
                let localPitch = localStorage.getItem("voicePitch" + voiceType);
                pitchEle.value = voicePitch[voiceType] = parseFloat(localPitch || pitchEle.getAttribute("value"));
                pitchEle.style.backgroundSize = (pitchEle.value - pitchEle.min) * 100 / (pitchEle.max - pitchEle.min) + "% 100%";
            }
            pitchEle.oninput = () => {
                pitchEle.style.backgroundSize = (pitchEle.value - pitchEle.min) * 100 / (pitchEle.max - pitchEle.min) + "% 100%";
                voicePitch[voiceType] = parseFloat(pitchEle.value);
                localStorage.setItem("voicePitch" + voiceType, pitchEle.value);
            }
            voicePitchChange();
            document.getElementById("voiceTypes").onclick = (ev) => {
                let type = ev.target.dataset.type;
                if (type !== void 0) {
                    type = parseInt(type);
                    if (type != voiceType) {
                        voiceType = type;
                        ev.target.classList.add("selVoiceType");
                        ev.target.parentElement.children[type ^ 1].classList.remove("selVoiceType");
                        voiceChange();
                        voiceVolumeChange();
                        voiceRateChange();
                        voicePitchChange();
                    }
                };
            };
            const voiceTestEle = document.getElementById("testVoiceText");
            let localTestVoice = localStorage.getItem("voiceTestText");
            voiceTestText = voiceTestEle.value = localTestVoice || voiceTestEle.getAttribute("value");
            voiceTestEle.oninput = () => {
                voiceTestText = voiceTestEle.value;
                localStorage.setItem("voiceTestText", voiceTestText);
            }
            const contVoiceEle = document.getElementById("enableContVoice");
            let localCont = localStorage.getItem("enableContVoice");
            contVoiceEle.checked = enableContVoice = (localCont || contVoiceEle.getAttribute("checked")) === "true";
            contVoiceEle.onchange = () => {
                enableContVoice = contVoiceEle.checked;
                localStorage.setItem("enableContVoice", enableContVoice);
            }
            contVoiceEle.dispatchEvent(new Event("change"));
            const autoVoiceEle = document.getElementById("enableAutoVoice");
            let localAuto = localStorage.getItem("enableAutoVoice");
            autoVoiceEle.checked = enableAutoVoice = (localAuto || autoVoiceEle.getAttribute("checked")) === "true";
            autoVoiceEle.onchange = () => {
                enableAutoVoice = autoVoiceEle.checked;
                localStorage.setItem("enableAutoVoice", enableAutoVoice);
            }
            autoVoiceEle.dispatchEvent(new Event("change"));
        };
        initVoiceFunc();
        speechServiceEle.dispatchEvent(new Event("change"));
